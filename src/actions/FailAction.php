<?php

namespace app\actions;

/**
 * Авторизация провалилась
 */
class FailAction extends AbstractAction
{
    public function run($provider)
    {
        throw new \Exception('Failed to connect to server');
    }
}