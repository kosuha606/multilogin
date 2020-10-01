<?php

namespace app\actions;

use Hybridauth\Hybridauth;

/**
 * Попытка авторизации
 */
class LoginAction extends AbstractAction
{
    public function run($provider, $saveRedirect = false)
    {
        if (!$saveRedirect) {
            $_SESSION['redirect'] = null;
        }

        if (isset($_GET['redirect'])) {
            $_SESSION['redirect'] = $_GET['redirect'];
        }

        $config = $this->application->getProviders();

        $config['callback'] .= "{$provider}";
        $hybridauth = new Hybridauth($config);

        $adapter = $hybridauth->authenticate($provider);

        $isConnected = $adapter->isConnected();

        $userProfile = $adapter->getUserProfile();

        $adapter->disconnect();

        return [
            'is_connected' => $isConnected,
            'profile' => $userProfile,
        ];
    }
}