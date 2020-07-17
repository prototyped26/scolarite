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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', 'Api\UserController@logout')->name('out');

//Route::get('/{any?}', "HomeController@index")->where('any', '.*');
Route::get('/utilisateurs/{any}', "HomeController@index")->where('any', '.*');
Route::get('/parents/{any}', "HomeController@index")->where('any', '.*');
Route::get('/classes/{any}', "HomeController@index")->where('any', '.*');
Route::get('/eleves/{any}', "HomeController@index")->where('any', '.*');
Route::get('/paiements/{any}', "HomeController@index")->where('any', '.*');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

