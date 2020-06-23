<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ProductController@home');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');

Route::resource('contacts', 'ContactController');

Route::resource('categories', 'CategoryController');

Route::resource('cart', 'CartController')->middleware('auth');

Route::resource('products', 'ProductController');//->middleware('auth');

Route::resource('user', 'Auth\ProfileController');

Route::post('products/upload', 'ProductController@upload');
Route::post('cart/addProduct/{id}', 'CartController@addCartProduct');
Route::post('cart/deleteProduct/{id}', 'CartController@deleteCartProduct');

Route::post('products/removeImage/{id}', 'ProductController@removeImage');
Route::get('/redirect-google', 'Auth\LoginController@redirectToProviderGoogle');
Route::get('/redirect-facebook', 'Auth\LoginController@redirectToProviderFacebook');
Route::get('/redirect-twitter', 'Auth\LoginController@redirectToProviderTwitter');
Route::get('/redirect-linkedin', 'Auth\LoginController@redirectToProviderLinkedin');

//Redirect URI`s :
Route::get('/google-auth', 'Auth\LoginController@handleProviderCallback');
Route::get('/facebook-auth', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('/twitter-auth', 'Auth\LoginController@handleProviderCallbackTwitter');

