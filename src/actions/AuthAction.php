<?php

namespace app\actions;

class AuthAction extends AbstractAction
{
    public function run($provider)
    {
        $currentUser = $this->application->getCurrentUser();
        $token = $this->application->buildUserToken($currentUser['user'], $currentUser['password']);
        $_SESSION['multilang_token'] = $token;

        return [
            'token' => $token
        ];
    }
}