<?php

/**
 * Общие настройки системы
 */

use app\actions\AuthAction;
use app\actions\FailAction;
use app\actions\LoginAction;
use app\actions\ProfileAction;
use app\actions\SuccessAction;

return [
    'is_debug' => true,
    'is_dump' => false,
    'salt' => '1231sdswew',
    'actions' => [
        'auth' => AuthAction::class,
        'login' => LoginAction::class,
        'success' => SuccessAction::class,
        'fail' => FailAction::class,
        'profile' => ProfileAction::class,
    ]
];