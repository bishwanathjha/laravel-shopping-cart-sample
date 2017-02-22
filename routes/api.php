<?php
/**
 * Application routes condition wise
 */
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    if(IsModifying())
        Route::resource('products','Api\ProductController');

    if(!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] != 'POST')
        Route::resource('users','Api\UserController');
});

Route::post('/v1/users', 'Api\UserController@store');
Route::get('/v1/products', 'Api\ProductController@index');
Route::get('/v1/products/{id?}', 'Api\ProductController@show');
Route::resource('/v1/cart','Api\CartController');

// User sign-up/login related route
Auth::routes();

/**
 * This is just workaround to detect action name
 */
function IsModifying() {
    return isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE');
}
