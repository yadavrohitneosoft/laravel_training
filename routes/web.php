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


//using the middleware - prevent-back-history to prevent going back from the browser after logout or session timeout

//Auth Routing
Route::group(['middleware' => 'prevent-back-history'], function() { 
    Route::get('/','Admin\Administrator@index'); 
    Route::get('/login','Admin\Administrator@index')->name('login');
    Route::post('/post_login','Admin\Authentication\LoginController@index');
    Route::get('/logout','Admin\Administrator@logout');
    Route::get('/register','Admin\Authentication\LoginController@register');
    Route::post('/do_register','Admin\Authentication\LoginController@doRegister'); 
    Route::post('/checkUserAccount', 'Admin\Authentication\LoginController@checkUserAccount');
});

//Dashboard Routing
Route::group(['prefix' => '/dashboard', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/index','Admin\Administrator@home')->name('dashboardHome'); 
});
//Property dashboard Routing
Route::group(['prefix' => '/manage-property', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/','Admin\Property\PropertyController@index')->name('propertyHome');
    Route::get('/getProperty','Admin\Property\PropertyController@getProperty');
    Route::post('/add_property','Admin\Property\PropertyController@add_property');
    Route::post('/property-detail','Admin\Property\PropertyController@property_detail');
    
});
//Property site Routing
Route::group(['prefix' => '/property', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/property-home','Admin\Property\PropertyController@property_home')->name('propertySiteHome'); 
    Route::get('/property-detail/{id}','Admin\Property\PropertyController@site_property_details')->name('propertydetails'); 
    Route::post('/property-detail/message','Admin\Property\PropertyController@message');
    
});
//Mailbox Routing
Route::group(['prefix' => '/mailbox', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/mailbox-home','Admin\Mailbox\MailboxController@index')->name('mailboxHome');
    Route::get('/getMailbox','Admin\Mailbox\MailboxController@getMailbox');   
    
});

//Users Routing
Route::group(['prefix' => '/manage-users', 'middleware' => 'prevent-back-history'], function() {
    Route::get('/','Admin\User\UserController@index')->name('usersHome'); 
    Route::get('/getUsers', 'Admin\User\UserController@getUsers')->name('getUsers'); 
    Route::get('/getUserDetails/{id}','Admin\User\UserController@getUserDetails')->name('editUser'); 
    Route::post('/do_update_user','Admin\User\UserController@updateUser')->name('updateUser');  
});

    

