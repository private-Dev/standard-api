<?php


use api\controllers\ApiInfoController\ApiInfoController;
use api\controllers\UserController\UserController;

require __DIR__.'/vendor/autoload.php';
include  __DIR__.'/env.php';


$settings = [
'settings' => [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => false,
    ]
];

$app = new \Slim\App($settings);


/*
 * Add to container PDO, errorHandler, Routes auth, ...
 */
$container = $app->getContainer();



/**
 * @return UserController
 */
$container['UserController'] = function ($container){
    // we can pass $container->obj to Ctrl
    //new UserController($container->view) for example
 return new UserController($container);
};

/**
 * @return ApiInfoController
 */
$container['ApiInfoController'] = function ($container){
    return new ApiInfoController($container);
};



include_once __DIR__ . '/secure.php';
require  __DIR__ . '/api/router.php';

