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
$container['UserController'] = function (){
 return new UserController();
};

/**
 * @return ApiInfoController
 */
$container['ApiInfoController'] = function (){
    return new ApiInfoController();
};



include_once __DIR__ . '/secure.php';
require  __DIR__ . '/api/router.php';

