<?php


use api\controllers\ApiInfoController\ApiInfoController;
use api\controllers\UserController\UserController;

$app->group('/api/v1/votes/', function ()  {});


$app->group('/api/v1/', function () use ($app) {
    /*      INFO    */
    $app->get('info',ApiInfoController::class . ':info' );
    /*      USERS    */
    $this->group('user/', function () use ($app) {

        $app->post('login', UserController::class . ':login');
        $app->get('token/check',UserController::class . ':checkToken');

        $app->get('profil', UserController::class . ':profil');
        $app->get('avatar', UserController::class .  ':avatar');

    });
    /*      administration    */
    $app->group('/admin/', function () use ($app) {});

});





// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
/*$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
*/
