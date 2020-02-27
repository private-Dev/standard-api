<?php
/**
 * Created by PhpStorm.
 * User: root-home
 * Date: 26/02/2020
 * Time: 18:47
 */



//namespace api\secure;
/*
 *  option requested by browser
 */
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});


/*
 * Check if route authorisation is ok
 */
$app->add(function ($request, $response, $next) {

    $authorized = false;

    if(!$request->isGet() && !$request->isPost()) {
        $authorized = true;
    }
    else {

        // seule la route user/login est autorisée.
        // 'user\/login|user\/avatar\/([a-zA-Z0-9]+)|fix\/|^(\/)?tracking\/|explorer|fallback\/([a-z0-9]+)\.([a-z0-9]+)\.([a-z0-9]+)\/([a-zA-Z0-9]+)|^(\/)?205a\/|^(\/)?r237\/'
        $whiteList = 'user\/login|\/info'; //
        preg_match('/' . $whiteList . '/', $request->getUri()->getPath(), $matches);
        //var_dump('/' . $whiteList . '/');
        if(count($matches) > 0) {
            $authorized = true;
        }
        //sinon on doit avoir un tocken que l'on va tester
        // sur la table des users.
        else {
            $tokenAuth = $request->getHeader('Authorization');
            if(!empty($tokenAuth)) {
                  //$db = $this->pdo;
                  // $db->stateObj();
                // appel
                //$mapper = new \Baliseo\Mapper\UserMapper($this->pdo);
                //$this->user = $mapper->getByToken($tokenAuth[0]);
                // if(!empty($this->user)) {
                //     $authorized = true;
            }
        }
    }


    if(!$authorized) {
        $response->getBody()->write('Unauthorized bad or empty token');
        return $response->withStatus(501);
    }
    else {
        $response = $next($request, $response);

        /*
         * Si nous sommes authorisé à compresser le résultat, alors on va pas se géner
         */
        if (!$response->hasHeader('Content-Encoding') && $request->hasHeader('Accept-Encoding') && stristr($request->getHeaderLine('Accept-Encoding'), 'gzip') !== false) {
           $compressed = gzencode($response->getBody());
            $stream = fopen('php://memory', 'r+');
            fwrite($stream, $compressed);
            rewind($stream);
            $response->withBody(new \Slim\Http\Stream($stream))
                ->withHeader('Content-Encoding', 'gzip')
                ->withHeader('Content-Length', strlen($compressed));
        }

        return $response
            /*  ouvert au 4 vents
                pour répondre aux besoins d'accés API distant,
                sécurisation par token
            */
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, Time')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
});