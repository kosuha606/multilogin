<?php

namespace app\actions;

/**
 * Авторизация успешно выполнена
 */
class SuccessAction extends AbstractAction
{
    public function run($provider)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        try {
            $loginAction = new LoginAction($this->application);
            $data = $loginAction->run($provider, true);
            $data['provider'] = $provider;

            $idForUser = false;
            if (isset($data['profile'])) {
                $idForUser = $provider.'_'.$data['profile']->identifier;
                file_put_contents(__DIR__.'/../../storage/'.$idForUser.'.json', json_encode($data, JSON_UNESCAPED_UNICODE));
            }

            $data = ['id' => $idForUser];

            if (isset($_SESSION['redirect'])) {
                $data['redirect'] = $_SESSION['redirect'];
            }

            $data = json_encode($data, JSON_UNESCAPED_UNICODE);

            require_once __DIR__.'/../views/success.php';
        } catch (\Exception $exception) {
            $data = ['id' => false];
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);

            require_once __DIR__.'/../views/success.php';
        }

        return false;
    }
}