<?php


require __DIR__.'/vendor/autoload.php';

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

/*
 * PDO connexion to mysql
 */
/*$container['pdo'] = function ($container) {

    $pdo = new api\classes\database\Database();

    return $pdo;

};
*/



include_once __DIR__ . '/secure.php';


require  __DIR__ . '/api/router.php';

