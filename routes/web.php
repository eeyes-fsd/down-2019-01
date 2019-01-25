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

Route::get('/download/{file}', 'Api\FilesController@Download')->name('download');

Route::get('login', 'Auth/OauthLoginController@login')->name('login');
Route::get('callback', 'Auth/OauthLoginController@callback')->name('callback');
Route::post('logout', 'Auth/OauthLoginController@logout')->name('logout');

Route::view('/', 'pages.root')->name('root');
Route::view('/admin', 'pages.admin')->name('admin');