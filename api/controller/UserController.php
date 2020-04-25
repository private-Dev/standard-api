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
     * premiere apporche , l'utilisateur se log et recupere son token
     * ce token, couplé avec son email,  servira de pass pour les endpoints
     * de l'api.
     * @param $requesr
     * @param $response
     */
    public function login(Request $request,Response $response, $args = []){
        //extract($args);
        $value = json_decode($request->getBody());
        //var_dump($value->password,$value->email);


         //var_dump($args);

        // create all vars from args
        /*
                 // extract body vars
                 $value = json_decode($request->getBody());
                 var_dump($value);
                 var_dump($value->email);

                 // extracts headers vars
                 $e = $request->getHeader('email')[0];
                 $p =$request->getHeader('password')[0];

               */
        $u = new User();
        return $response->withJson($u->Auth($value->email,$value->password));

    }

    public function profil(Request $request,Response $response, $args = []){

        // extract($args);
        $value = json_decode($request->getBody());
        $u = new User();

        //return $response->withJson($u->Auth($value->email,$value->password));


    }
    public function avatar(Request $request,Response $response, $args = []){

        $value = json_decode($request->getBody());
        //var_dump($value);
        //var_dump($value->email);

        return $response->withStatus(200)->write('We want to ckeck Avatar');
    }

    public function checkToken(Request $request,Response $response, $args = []){

        var_dump($request->getHeaders());
       // var_dump($this);die();
        //var_dump('entering User ctrl checkToken function');
       // var_dump($request->getHeader('Authorization'));
        //var_dump("check tocken api",$this->user);
        $return = [
            //'ok'=>empty($this->user) ? false : true,
            //'token'=>$this->user->token,
            'ok' => true,
            'token'=> 'zeff5',
        ];
  /*
        if(!empty($this->user)) {

            //$this->pdo->debug=true;
            $mapper = new UserMapper($this->pdo);
            $token = $mapper->renewToken($this->user, false, 600);
            $return['token'] = $token;

        }

*/
        return $response->withJson($return);


    }
}