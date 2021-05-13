<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/','Admin\Administrator@index'); 
Route::get('/login','Admin\Administrator@index');
Route::post('/post_login','Admin\Authentication\LoginController@index');
Route::get('/logout','Admin\Administrator@logout');
Route::get('/register','Admin\Authentication\LoginController@register');
Route::post('/do_register','Admin\Authentication\LoginController@doRegister');
Route::get('/test', 'Admin\Category\CategoryController@getCat');

//using the middleware - prevent-back-history to prevent going back from the browser after logout or session timeout

//Dashboard Routing
Route::group(['prefix' => '/dashboard', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/index','Admin\Administrator@home')->name('dashboardHome');
});
//Category Routing
Route::group(['prefix' => '/manage-category', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/','Admin\Category\CategoryController@index')->name('categoryHome');
    Route::get('/getCategories', 'Admin\Category\CategoryController@getCategories')->name('getCategory');
    Route::post('/add_category', 'Admin\Category\CategoryController@addCategory')->name('addCategory');
    Route::get('/changeCatStatus/{id}', 'Admin\Category\CategoryController@changeCategoryStatus')->name('changeCategoryStatus');
    Route::get('/deleteCategory/{id}','Admin\Category\CategoryController@deleteCategory')->name('deleteCategory');
    Route::get('/getCatDetails/{id}', 'Admin\Category\CategoryController@getCategoryDetails')->name('editCategory');
    Route::post('/do_update_category','Admin\Category\CategoryController@updateCategory')->name('updateCategory');
});
//Product Routing
Route::group(['prefix' => '/manage-products', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/','Admin\Product\ProductController@index')->name('productsHome');
    Route::get('/getProducts', 'Admin\Product\ProductController@getProducts')->name('getProducts');
    Route::post('/add_product', 'Admin\Product\ProductController@addProduct')->name('addProduct');
    Route::get('/editProductDetails/{id}', 'Admin\Product\ProductController@editProductDetails')->name('editProduct');
    Route::post('/do_update_product','Admin\Product\ProductController@updateProduct')->name('updateProduct');
    Route::get('/deleteProduct/{id}','Admin\Product\ProductController@deleteProduct')->name('deleteProduct');
    Route::get('/changeProdStatus/{id}', 'Admin\Product\ProductController@changeProductStatus')->name('changeProductStatus');
});
//Users Routing
Route::group(['prefix' => '/manage-users', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/','Admin\User\UserController@index')->name('usersHome');
    Route::post('/do_update_user','Admin\User\UserController@updateUser')->name('updateUser');
    Route::get('/getUsers', 'Admin\User\UserController@getUsers')->name('getUsers');
    Route::post('/add_user','Admin\User\UserController@addUser')->name('addUser');
    Route::get('/deleteUser/{id}','Admin\User\UserController@deleteUser')->name('deleteUser');
    Route::get('/getUserDetails/{id}','Admin\User\UserController@getUserDetails')->name('editUser');
    Route::get('/changeStatus/{id}', 'Admin\User\UserController@changeUserStatus')->name('changeUserStatus');
});

    

