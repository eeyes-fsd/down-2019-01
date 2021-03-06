<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->middleware(['bindings'])->group(function () {
    Route::resource('files', 'FilesController', ['only' => ['index', 'update', 'destroy']]);
    Route::get('files/refresh', 'FilesController@refresh')->name('files.refresh');
    Route::resource('items', 'ItemsController');
    Route::post('icons', 'ItemsController@upload_icon')->name('icon');
    Route::get('icons', 'ItemsController@get_icons')->name('icon');
    Route::get('comments/{user}', 'CommentsController@show')->name('comments.show');
    Route::resource('comments', 'CommentsController', ['only' => ['index', 'store', 'destroy']]);
});