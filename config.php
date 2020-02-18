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

// This is the middleware
// It will add the Access-Control-Allow-Methods header to every request

$app->add(function($request, $response, $next) {
    $route = $request->getAttribute("route");
    $methods = [];
    if (!empty($route)) {
        $pattern = $route->getPattern();
        foreach ($this->router->getRoutes() as $route) {
            if ($pattern === $route->getPattern()) {
                $methods = array_merge_recursive($methods, $route->getMethods());
            }
        }
        //Methods holds all of the HTTP Verbs that a particular route handles.
    } else {
        $methods[] = $request->getMethod();
    }

    $response = $next($request, $response);
    return $response->withHeader("Access-Control-Allow-Methods", implode(",", $methods));
});


$app->group('/api/v1/', function () use ($app) {

    $app->get('', function (Request $request, Response $response, Array $args) {

        var_dump($request->getHeader('api_user_token'));

        return $response->withJson("entering v1");
    });


});
