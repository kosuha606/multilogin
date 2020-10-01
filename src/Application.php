<?php

namespace app;

use app\actions\AbstractAction;

/**
 * Class Application
 * @package app
 */
class Application
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @var array
     */
    private $providers;

    /**
     * @var array
     */
    private $users;

    private $currentUser = ['user' => 'guest', 'password' => 'no'];

    private $dump = [];

    /**
     * Application constructor.
     * @param $settings
     * @param $providers
     * @param $users
     */
    public function __construct(
        $settings,
        $providers,
        $users
    ) {
        $this->settings = $settings;
        $this->providers = $providers;
        $this->users = $users;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        session_start();
        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode('?', $uri);
        $uriParts = array_values(array_filter(explode('/', $parts[0])));
        $this->dump($uriParts);

        $action = $uriParts[0] ?? 'login';
        $provider = $uriParts[1] ?? 'noprovider';
        $user = $_GET['user'] ?? 'guest';
        $password = $_GET['password'] ?? 'password';

        if (isset($_GET['token'])) {
            $token = $_GET['token'] ?? 'empty';
            $_SESSION['multilang_token'] = $_GET['token'];
        } else {
            $this->dump('build token');

            if ($user !== 'guest' && $password !== 'password') {
                $token = $this->buildUserToken($user, $password);
                $_SESSION['multilang_token'] = $token;
            } else {
                $token = $_SESSION['multilang_token'];
            }
        }

        $this->dump('Token: '.$token);
        $this->dump('User: '.$user);
        $this->dump('Password: '.$password);

        if (!$this->checkAuth($user, $password, $token)) {
            throw new \Exception('Not authorized');
        }

        $this->dump(json_encode($this->settings['actions']));

        if (!isset($this->settings['actions'][$action])) {
            throw new \Exception('No such action');
        }

        $this->currentUser['user'] = $user;
        $this->currentUser['password'] = $password;

        $actionClass = $this->settings['actions'][$action];
        /** @var AbstractAction $actionInst */
        $actionInst = new $actionClass($this);
        $result = $actionInst->run($provider);

        if ($result) {
            $this->responseJson([
                'result' => true,
                'data' => $result,
            ]);
        }
    }

    /**
     * Проверка валидности пользователя по имени и паролю либо по токену
     *
     * @param $login
     * @param $password
     * @return bool
     */
    public function checkAuth($login, $password, $userToken = 'empty')
    {
        foreach ($this->users as $user) {
            $token = $this->buildUserToken($user['user'], $user['password']);
            if (
                $user['user'] == $login
                && $user['password'] == $password
            ) {
                return true;
            }

            if ($token === $userToken) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool|mixed
     */
    public function isDebug()
    {
        return $this->settings['is_debug'] ?? false;
    }

    public function dump($message)
    {
        if ($this->settings['is_dump']) {
            $this->dump[] = $message;
        }
    }

    /**
     * @param $data
     */
    public function responseJson($data)
    {
        header('Content-Type: application/json');

        if ($this->settings['is_dump']) {
            $data['dump'] = $this->dump;
        }

        echo json_encode($data);
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @return array
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @return array
     */
    public function getDump(): array
    {
        return $this->dump;
    }

    /**
     * @return array
     */
    public function getCurrentUser(): array
    {
        return $this->currentUser;
    }

    /**
     * Для каждого пользователя есть возможность войти по токену
     * токен меняется каждый час автоматически
     *
     * @param $user
     * @param $password
     * @return string
     */
    public function buildUserToken($user, $password)
    {
        $date = date('d_m_Y__H');

        return md5($user.$password.$date.$this->settings['salt']);
    }
}