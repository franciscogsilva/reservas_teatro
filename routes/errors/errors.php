<?php

use Illuminate\Http\Request;

Route::get('/error-400', function(){
	return view('errors.error_400');
})->name('error.400');

Route::get('/error-401', function(){
	return view('errors.error_401');
})->name('error.401');

Route::get('/error-403', function(){
	return view('errors.error_403');
})->name('error.403');

Route::get('/error-404', function(){
	return view('errors.error_404');
})->name('error.404');

Route::get('/error-500', function(){
	return view('errors.error_500');
})->name('error.500');

Route::get('/error-503', function(){
	return view('errors.error_503');
})->name('error.503');