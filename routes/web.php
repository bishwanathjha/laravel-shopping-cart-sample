<?php
/**
 * Application web frontend routes
 */
// Home page
Route::get('/', 'Frontend\HomeController@index');
Route::get('/home', 'Frontend\HomeController@index');

// User sign-up/login related route
Auth::routes();

// Cart & Products route
Route::get('products/{id}-{any}', 'Frontend\ProductController@details');
Route::get('cart/products', 'Frontend\ProductController@cart');
Route::get('cart/checkout', 'Frontend\ProductController@checkout');

// Admin routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('/','Admin\LandingController@index');
    Route::get('/users/add','Admin\LandingController@user_add');
    Route::get('/users/view','Admin\LandingController@user_list');
    Route::get('/products/add','Admin\LandingController@product_add');
    Route::get('/products/view','Admin\LandingController@product_list');
});

