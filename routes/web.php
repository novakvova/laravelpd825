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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('contacts', 'ContactController');

Route::resource('categories', 'CategoryController');

Route::resource('products', 'ProductController');//->middleware('auth');

Route::post('products/upload', 'ProductController@upload');

Route::post('products/removeImage/{id}', 'ProductController@removeImage');
Route::get('/redirect-google', 'Auth\LoginController@redirectToProviderGoogle');
Route::get('/redirect-facebook', 'Auth\LoginController@redirectToProviderFacebook');
Route::get('/redirect-twitter', 'Auth\LoginController@redirectToProviderTwitter');
//Redirect URI`s :
Route::get('/google-auth', 'Auth\LoginController@handleProviderCallback');
Route::get('/facebook-auth', 'Auth\LoginController@handleProviderCallbackFacebook');
Route::get('/twitter-auth', 'Auth\LoginController@handleProviderCallbackTwitter');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
