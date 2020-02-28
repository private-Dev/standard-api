<?php
/**
 * Created by PhpStorm.
 * User: root-home
 * Date: 27/02/2020
 * Time: 19:31
 */



namespace api\controllers\UserController;



use api\controllers\Controller\Controller;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use api\models\user\User;

class UserController extends Controller {


    /**
     * @param $requesr
     * @param $response
     */
    public function login(Request $request,Response $response, $args = []){

        extract($args);
        $value = json_decode($request->getBody());
        //var_dump($value);
        //var_dump($value->email);

        $user  = new User();
        //return 'User Controller';
        return $response->withJson($user->Auth($value->email,$value->password));
    }

    public function avatar(Request $request,Response $response, $args = []){

        $value = json_decode($request->getBody());
        //var_dump($value);
        //var_dump($value->email);

        return $response->withStatus(200)->write('We want to ckeck Avatar');
    }
}