<?php

use api\classes\user\User;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



include_once __DIR__.'../classes/Database.php';
include_once __DIR__.'../classes/User.php';






$app->group('/api/v1/', function ()  {



    $this->get('info', function (Request $request, Response $response, Array $args) {

        //var_dump($request->getHeader('api_user_token'));
        $result['appName'] = "happyfrenchy";
        $result['version'] = "v1";
        $result['date'] = "27/02/2020";
        $result['author'] = "jpb";

        return $response->withJson($result);
    });



    $this->post('user/login/', function (Request $request,  Response $response, $args = []) {

        $value = json_decode($request->getBody());
        //var_dump($value);
        //var_dump($value->email);

        $user  = new User();
        return $response->withJson($user->Auth($value->email,$value->password));

    });

    $this->get('user/avatar', function (Request $request,  Response $response, $args = []) {


        $value = json_decode($request->getBody());
        var_dump($value);
        var_dump($value->email);

        return $response->withStatus(200)->write('We want to ckeck Avatar');

    });
});


// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
/*$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
*/
