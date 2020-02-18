<?php


require __DIR__.'/vendor/autoload.php';


$settings = [
'settings' => [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => false,
    ]
];


$app = new \Slim\App($settings);


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api/v1', function () use ($app) {

    $app->get('/', function (Request $request, Response $response, Array $args) {

        return $response->withJson("entering v1");
    });


});
