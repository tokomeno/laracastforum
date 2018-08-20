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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Route::get('/threads', 'ThreadController@index');
// Route::get('/threads/create', 'ThreadController@create');
// Route::post('/threads', 'ThreadController@store');
// Route::get('/threads/{thread}', 'ThreadController@show');


Route::resource('threads', 'ThreadController')
->except('show');

Route::get('/threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store'); // save reply

// store favorites
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');



