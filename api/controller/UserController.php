<?php
/**
 * Created by PhpStorm.
 * UserTest: root-home
 * Date: 27/02/2020
 * Time: 19:31
 */



namespace api\controllers\UserController;



use api\controllers\Controller\Controller;
use api\models\userModel\User;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class UserController extends Controller {


    /**
     * @param $requesr
     * @param $response
     */
    public function login(Request $request,Response $response, $args = []){

        // extract($args);
        $value = json_decode($request->getBody());
        $u = new User();

        return $response->withJson($u->Auth($value->email,$value->password));


    }

    public function avatar(Request $request,Response $response, $args = []){

        $value = json_decode($request->getBody());
        //var_dump($value);
        //var_dump($value->email);

        return $response->withStatus(200)->write('We want to ckeck Avatar');
    }
}