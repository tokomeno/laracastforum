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


Route::resource('threads', 'ThreadController')->except('show', 'destroy');
Route::post('/lock-thread/{thread}', 'LockThreadController@store')->name('lock.thread.store')->middleware('admin');
Route::delete('/lock-thread/{thread}', 'LockThreadController@destroy')->name('lock.thread.destroy')->middleware('admin');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store'); // save reply

Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');

Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.delete');
Route::post('/replies/{reply}', 'ReplyController@update');

// store favorites
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');

Route::post('/replies/{reply}/best', 'BestReplyController@store');



//Sub threads

Route::post('/threads/{channel}/{thread}/subscriptions',
	'ThreadSubscriptionController@store')->middleware('auth');

Route::delete('/threads/{channel}/{thread}/subscriptions',
	'ThreadSubscriptionController@destroy')->middleware('auth');


Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::delete('/profile/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('/profile/{user}/notifications', 'UserNotificationsController@index');


Route::get('/api/users', 'Api\UserController@index');

Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index');
