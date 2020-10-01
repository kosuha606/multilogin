<?php

/**
 * Приложение предназначено для того, чтобы избавить
 * разработчиков от необходимости пользоватеься сомнительными
 * сервисами мультивхода через социальные сети.
 *
 * Вместо исопльзования подобных сервисов Вы можете развернуть
 * этот проект на своем сервере, один раз настроить приложения в социальных
 * стеях для выхода ваших клиентов, и у вас будет собственный сервер входа через
 * социальные сети.
 */

use app\Application;

require __DIR__.'/../vendor/autoload.php';

$providers = require_once __DIR__.'/../config/providers.php';
$users = require_once __DIR__.'/../config/users.php';
$common = require_once __DIR__.'/../config/common.php';
$app = new Application($common, $providers, $users);

try {
    $app->run();
} catch (\Exception $exception) {
    $app->responseJson([
        'result' => false,
        'message' => 'Ошибка сервера'.($app->isDebug() ? ' #'.$exception->getMessage() : ''),
    ]);
}
