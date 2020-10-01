<?php

namespace app\client;

class Login
{
    public $baseUri = 'https://multilogin.kosuha606.ru/';

    private $password;

    private $user;

    public function __construct($user, $password)
    {
        $this->password = $password;
        $this->user = $user;
    }

    public function getToken()
    {
        $response = file_get_contents($this->baseUri.'auth?'.http_build_query([
            'user' => $this->user,
            'password' => $this->password,
        ]));
        $responseData = json_decode($response, true);

        return isset($responseData['data']['token']) ? $responseData['data']['token'] : false;
    }

    public function getProfileData($id)
    {
        $token = $this->getToken();
        $response = file_get_contents($this->baseUri.'profile?'.http_build_query([
            'token' => $token,
            'id' => $id,
        ]));
        $responseData = json_decode($response, true);

        return $responseData;
    }
}