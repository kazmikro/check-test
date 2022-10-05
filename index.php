<?php

declare(strict_types=1);

use App\Controllers\{ArticleController, IndexController, UserController};
use App\Router;
use Illuminate\Container\Container;

require_once __DIR__ . '/vendor/autoload.php';

const STORAGE_PATH = __DIR__ . '/storage';
const VIEW_PATH = __DIR__ . '/views';

$container = new Container();
$router = new Router($container);

/** @noinspection PhpUnhandledExceptionInspection */
$router->registerFromControllerAttributes(
    [
        IndexController::class,
        UserController::class,
        ArticleController::class,
    ]
);

/** @noinspection PhpUnhandledExceptionInspection */
(new \App\App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->boot()->run();
