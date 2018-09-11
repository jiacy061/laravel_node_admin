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


use Illuminate\Support\Facades\Route;

// VPN管理系统API
Route::get('/', function () {
    return view('index');
});

Route::get('/vpn/register', ['as'=>'registerUrl', 'uses'=>'VpnController@registerPage']);

Route::post('/vpn/register', ['as'=>'registerPost', 'uses'=>'VpnController@registerPost']);

Route::get('/vpn/login', ['as'=>'loginUrl', 'uses'=>'VpnController@loginPage']);

Route::post('/vpn/admin', ['as'=>'loginPost', 'uses'=>'VpnController@loginPost']);

Route::get('/vpn/account/{port}', ['as'=>'accountUrl', 'uses'=>'VpnController@accountPage']);

Route::get('/vpn/config/{port}', ['as'=>'configUrl', 'uses'=>'VpnController@configPage']);

Route::get('/vpn/about/{port}', ['as'=>'aboutUrl', 'uses'=>'VpnController@aboutPage']);

Route::post('/vpn/config/{port}', ['as'=>'updateConfigUrl', 'uses'=>'VpnController@updatePost']);


