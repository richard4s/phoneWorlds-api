<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/database', function () use ($app) {
    $db = app()->make('db');

    if ( $db->connection()->getDatabaseName() )
    {
        return 'Connected to the DB: ' . $db->connection()->getDatabaseName();
    }
    else
    {
        return 'Unable to establish database connection...';
    }
});

$router->get('/', function () use ($router) {
    return response()->json(['success' => 'Welcome to PhoneWorld!']);
});

$router->get('/api', function() use ($router) {
    return response()->json(['success' => 'You\'ve hit our API baba!']);
});

$router->get('/key', function() {
    $bytes = random_bytes(32);
    return base64_encode($bytes);
});

//$router->get('/jwtTolen', function() {
//    OAUTH_SIG_METHOD_HMACSHA256(
//        strtr(base64_encode($input), '+/=', '._-')
//    )
//    return base64_encode($bytes);
//});

//jxkj

$router->group(
    ['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->get('users', function() {
            $users = \App\User::all();
            return response()->json(['users' => $users]);
        });
    }
);

$router->post(
    'auth/login',
    [
        'uses' => 'AuthController@authenticate'
    ]
);

$router->get('/register', 'RegisterController@store');
