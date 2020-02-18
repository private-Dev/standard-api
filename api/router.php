<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $req,  Response $res, $args = []) {
    return $res->withStatus(200)->write('very cool Request');
});