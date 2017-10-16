<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//后台登录页面
Route::get('admin/login','Admin\LoginController@login');

//验证码路由
Route::get('admin/yzm','Admin\LoginController@yzm');

//后台登录验证页
Route::post('admin/dologin','Admin\LoginController@dologin');



//后台首页路由
// Route::get('admin/index','Admin\IndexController@index');
