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

Route::group(['prefix' => '/'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/login', 'Auth\AuthController@index')->name('login');
    Route::post('/login', 'Auth\AuthController@login')->name('loginRequest');
});

/** WEB */
Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
});
