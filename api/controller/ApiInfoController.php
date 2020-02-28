<?php
/**
 * Created by PhpStorm.
 * User: root-home
 * Date: 27/02/2020
 * Time: 21:32
 */

namespace api\controllers\ApiInfoController;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiInfoController
{


    public function info(Request $request,Response $response, $args = []){
        $result['appName'] = "happyfrenchy";
        $result['version'] = "v1";
        $result['date'] = "27/02/2020";
        $result['author'] = "jpb";

        return $response->withJson($result);
    }
}