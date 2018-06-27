<?php

Auth::routes();

// Authentication routes...
Route::get('login-or-reg', 'Auth\AuthCustomController@getLogin');
// Route::post('login', 'Auth\AuthCustomController@postLogin');
Route::get('logout', 'Auth\AuthCustomController@getLogout');

// Registration routes...
// Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthCustomController@postRegister');
// Route::get('confirm/{token}', 'Auth\AuthCustomController@confirm');

// Confirmation of registration
// Route::get('confirm-register', 'Auth\AuthCustomController@getConfirmRegister');
// Route::post('confirm-register', 'Auth\AuthCustomController@postConfirmRegister');

// Password reset link request routes...
// Route::get('password/email', 'Auth\PasswordController@getEmail');
// Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
// Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
// Route::post('password/reset', 'Auth\PasswordController@postReset');

// Profile
Route::group(['middleware' => 'auth', 'role:user'], function() {

    Route::get('my-profile', 'ProfileController@profile');
    Route::post('my-profile', 'ProfileController@updateProfile');
    Route::get('my-profile/edit', 'ProfileController@editProfile');
    Route::get('my-orders', 'ProfileController@myOrders');
});

// Joystick Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {

    Route::get('/', 'Joystick\AdminController@index');

    Route::resource('categories', 'Joystick\CategoryController');
    Route::resource('countries', 'Joystick\CountryController');
    Route::resource('companies', 'Joystick\CompanyController');
    Route::resource('cities', 'Joystick\CityController');
    Route::resource('news', 'Joystick\NewController');
    Route::resource('languages', 'Joystick\LanguageController');
    Route::resource('modes', 'Joystick\ModeController');
    Route::resource('options', 'Joystick\OptionController');
    Route::resource('orders', 'Joystick\OrderController');
    Route::resource('pages', 'Joystick\PageController');
    Route::resource('products', 'Joystick\ProductController');
    Route::get('products-search', 'Joystick\ProductController@search');
    Route::get('products-category/{id}', 'Joystick\ProductController@categoryProducts');
    Route::get('products-actions', 'Joystick\ProductController@actionProducts');
    Route::get('products-price/edit', 'Joystick\ProductController@priceForm');
    Route::post('products-price/update', 'Joystick\ProductController@priceUpdate');

    Route::resource('roles', 'Joystick\RoleController');
    Route::resource('users', 'Joystick\UserController');
    Route::resource('permissions', 'Joystick\PermissionController');

    Route::get('apps', 'Joystick\AppController@index');
    Route::get('apps/{id}', 'Joystick\AppController@show');
    Route::delete('apps/{id}', 'Joystick\AppController@destroy');
});


// Input
Route::get('search', 'InputController@search');
Route::get('search-ajax', 'InputController@searchAjax');
Route::post('filter-products', 'InputController@filterProducts');
Route::post('send-app', 'InputController@sendApp');


// Basket Actions
Route::get('add-to-basket/{id}', 'BasketController@addToBasket');
Route::get('remove-from-basket/{id}', 'BasketController@removeFromBasket');
Route::get('clear-basket', 'BasketController@clearBasket');
Route::get('basket', 'BasketController@basket');
Route::get('basket/{id}', 'BasketController@destroy');
Route::post('store-order', 'BasketController@storeOrder');


// Favorite Actions
// Route::get('toggle-favorite/{id}', 'FavoriteController@toggleFavorite');


// Pages
Route::get('/', 'PageController@index');
Route::get('catalog', 'PageController@catalog');
Route::get('catalog/{category}', 'PageController@categoryProducts');
Route::get('goods/{id}-{product}', 'PageController@product');
Route::get('catalog/brand/{company}', 'PageController@brandProducts');
Route::get('kontakty', 'PageController@contacts');
Route::get('{page}', 'PageController@page');
