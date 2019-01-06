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

include_once 'errors/errors.php';

Route::get('/', 'HomeController@index')->name('welcome');
Route::get('/validate-chair/{id}', 'ChairController@validateChair')->name('validate-chair');
Route::get('/get-chairs', 'ChairController@getChairs')->name('get-chairs');

Route::group(['middleware' => ['web','auth']], function () {
	Route::resource('reservations', 'ReservationController');
	Route::get('reservations/{id}/destroy', 'ReservationController@destroy')->name('reservations.destroy');

	Route::get('users', 'UserController@edit')->name('users.edit');
	Route::put('users', 'UserController@update')->name('users.update');
});

Auth::routes();
