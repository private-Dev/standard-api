<?php


use api\controllers\ApiInfoController\ApiInfoController;
use api\controllers\UserController\UserController;

$app->group('/api/v1/votes/', function ()  {});


$app->group('/api/v1/', function ()  {

    $this->get('info',ApiInfoController::class . ':info' );


    $this->post('user/login', UserController::class . ':login');
    $this->get('user/profil', UserController::class . ':profil');
    $this->get('user/token/check',UserController::class . ':checkToken');
    $this->get('user/avatar', UserController::class .  ':avatar');

});

$app->group('/api/v1/admin/', function ()  {});



// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
/*$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
*/
