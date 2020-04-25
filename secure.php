<?php
/**
 * Created by PhpStorm.
 * UserTest: root-home
 * Date: 26/02/2020
 * Time: 18:47
 */

/*
 *  option requested by browser
 */

use api\models\userModel\User;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});


/*
 * Check if route authorisation is ok [  Middleware ]
 */
$app->add(function ($request, $response, $next) {

    //var_dump('entering middleware function');
    $authorized = false;

    if (!$request->isGet() && !$request->isPost()) {
        $authorized = true;
    } else {

        // seule les routes user/login et /info sont  autorisée sans authentification.
        // 'user\/login|user\/avatar\/([a-zA-Z0-9]+)|fix\/|^(\/)?tracking\/|explorer|fallback\/([a-z0-9]+)\.([a-z0-9]+)\.([a-z0-9]+)\/([a-zA-Z0-9]+)|^(\/)?205a\/|^(\/)?r237\/'
        $whiteList = 'user\/login|\/info'; //
        preg_match('/' . $whiteList . '/', $request->getUri()->getPath(), $matches);



        if (count($matches) > 0) {

            $authorized = true;
        }
        //sinon on doit avoir un tocken que l'on va tester
        // sur la table des users.
        else {

            $tokenAuth = $request->getHeader('Authorization');
            $mail = $request->getHeader('email');

            if (!empty($tokenAuth)) {
                $user  = new User();
                $currentUserToken = $user->checkByToken($tokenAuth[0],$mail[0]);
                if (!empty($currentUserToken)) {
                    var_dump('we are secure and logged');
                    $authorized = true;
                }
            }
        }
    }




    if (!$authorized) {
        $response->getBody()->write('Unauthorized bad or empty token');
        return $response->withStatus(501);

    } else {

        $response = $next($request, $response);
        if (!$response->hasHeader('Content-Encoding') && $request->hasHeader('Accept-Encoding')
            && stristr($request->getHeaderLine('Accept-Encoding'), 'gzip') !== false) {

            $compressed = gzencode($response->getBody());
            $stream = fopen('php://memory', 'r+');
            fwrite($stream, $compressed);
            rewind($stream);
            $response->withBody(new \Slim\Http\Stream($stream))
                ->withHeader('Content-Encoding', 'gzip')
                ->withHeader('Content-Length', strlen($compressed));
        }

        return $response
            /* sécurisation par token */
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, Time, email')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
});