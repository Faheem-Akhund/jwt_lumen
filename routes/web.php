<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\UserController;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->group(['prefix' => 'api'], function () use ($router) {
    
    $router->post('/create', "UserController@create");
   
   
   
    // Matches "/api/login
    $router->post('/login', 'UserController@login');
    $router->get('/data', "UserController@data");
    $router->post('/Studentcreate', "studentController@create");
});

// $router->post('/login', "UserController@login");


// Route::group([
    
    //     'middleware' => 'api',
    //     'prefix' => 'auth'
    
    // ], function ($router) {
        
        //     Route::post('login', 'AuthController@login');
        //     Route::post('logout', 'AuthController@logout');
        //     Route::post('refresh', 'AuthController@refresh');
        //     Route::post('me', 'AuthController@me');
        
        // });
        
        $router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
            
            $router->get('/fetch', "studentController@index");
            
        });
        