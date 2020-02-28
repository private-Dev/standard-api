<?php


use api\controllers\ApiInfoController\ApiInfoController;
use api\controllers\UserController\UserController;

require __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/env.php';


$settings = [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => false,
        'db' => [
            'driver' => 'mysql',
            'host' => HOST,
            'database' => DATABASE_NAME,
            'username' => USERNAME_DB,
            'password' => PASSWORD_DB,
            'charset' => DATABASE_CHARSET,
            'collation' => DATABASE_COLLATION,
            'prefix' => '',
        ]
    ]
];


$app = new \Slim\App($settings);


/*
 * Add to container PDO, errorHandler, Routes auth, ...
 */
$container = $app->getContainer();

// Illuminate way to use eloquent outside laravel
$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// add eloquent to container
$container['db'] = function($container) use ($capsule) {
    return $capsule;
};
/**
 * @return UserController
 */
$container['UserController'] = function ($container) {
    // we can pass $container->obj to Ctrl
    //new UserController($container->view) for example
    return new UserController($container);
};
/**
 * @return ApiInfoController
 */
$container['ApiInfoController'] = function ($container) {
    return new ApiInfoController($container);
};



include_once __DIR__ . '/secure.php';
require __DIR__ . '/api/router.php';

