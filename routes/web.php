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

$router->get('/', function() {
    return view()->make('client');
});

$router->get('/graphiql', function() {
    return view()->make('graphiql');
});

$router->post('/test.json', function () use ($router) {
    return [
        'test' => true
    ];
});

$router->get('/schema.json', function () use ($router) {
    return response()->json(json_decode(file_get_contents(resource_path('graphql/schema.json'))));
//    $schema = $router->app->make('graphql')->introspection('default');
//    return response()->json($schema);
});
$router->post('/schema.json', function () use ($router) {
    return response()->json(json_decode(file_get_contents(resource_path('graphql/schema.json'))));
//    $schema = $router->app->make('graphql')->introspection('default');
//    return response()->json($schema);
});

$router->post('login', function() use ($router) {
    $request = app()->make('request');
    /* @var $request Illuminate\Http\Request */
    $credentials = array(
        'username' => $request->input("username"),
        'password' => $request->input("password")
    );
    return $router->app->make('App\Auth\Proxy')->attemptLogin($credentials);
});

//// login for Lightspeed - LS WORKAROUND
//$router->post('token', function() use ($router) {
//    /* @var $request \Illuminate\Http\Request */
//    $request = app()->make('request');
//    $credentials = array(
//        'username' => $request->input("username"),
//        'password' => $request->input("password"),
//        'response' => ['token' => 'access_token']
//    );
//    return $router->app->make('App\Auth\Proxy')->attemptLogin($credentials);
//});

$router->post('refresh', function() use ($router) {
    $request = app()->make('request');
    /* @var $request Illuminate\Http\Request */
//    $jwt = new Lcobucci\JWT\Parser();
//    $tokenId = $jwt->parse($request->input('refresh_token'))->getClaim('jti');
//

    return $router->app->make('App\Auth\Proxy')->attemptRefresh($request->input('refresh_token'));
});


$router->group(['prefix' => 'pms', 'middleware' => ['auth:api', 'scopes:pms_access']], function($router)
{
    $router->get('', 'PMSController@index');

    $router->get('/platforms', 'PMSController@getPlatforms');

    $router->get('/{id}', 'PMSController@getRoom');

    $router->post('', 'PMSController@saveRoom');

    $router->put('', 'PMSController@updateRooms');

    $router->put('/{id}', 'PMSController@updateRoom');

});

$router->group(['prefix' => 'cm', 'middleware' => ['auth:api', 'scopes:cm_access']], function($router)
{
    $router->get('', 'BookingController@index');

//    $router->get('/platforms', 'PMSController@getPlatforms');
//
//    $router->get('/{id}', 'PMSController@getRoom');
//
//    $router->post('', 'PMSController@saveRoom');
//
//    $router->put('', 'PMSController@updateRooms');
//
//    $router->put('/{id}', 'PMSController@updateRoom');

});

$router->group(['prefix' => 'room', 'middleware' => ['lightspeed', 'auth:api', 'scopes:pos_access']], function($router)
{
    $router->get('', 'POSController@index');

    $router->get('/{id}', 'POSController@getRoom');

    $router->get('/charge/{id}', 'POSController@getCharge');

});

$router->group(['prefix' => 'room', 'middleware' => ['lightspeed', 'auth:api', 'scopes:pos_access,pos_charge']], function($router)
{
    $router->post('/{id}/charge', 'POSController@addRoomCharge');

    $router->delete('/{id}/charge/{chargeId}', 'POSController@deleteRoomCharge');

});

$router->group(['prefix' => 'tv', 'middleware' => ['auth:api', 'scopes:tv_access']], function($router)
{
    $router->get('', 'TVController@index');

    $router->get('/{id}', 'TVController@getRoom');

});

$router->group(['prefix' => 'tv', 'middleware' => ['auth:api', 'scopes:tv_access,tv_charge']], function($router)
{
    $router->post('/{id}/charge', 'TVController@addRoomCharge');

    $router->delete('/{id}/charge/{chargeId}', 'TVController@deleteRoomCharge');

});


$router->group(['prefix' => 'service', 'middleware' => ['auth:api', 'scopes:pms_access']], function($router)
{
    $router->get('', 'ServiceController@index');

    $router->get('/{cc}/{vat}', 'ServiceController@getVatInfo');

});
