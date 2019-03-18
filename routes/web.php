<?php
use App\User;

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
    // broadcast(new WebSocketDemoEvent('some data'));
    return view('welcome');
});

Route::get('/chats', 'ChatsController@index');
Route::get('/messages', 'ChatsController@fetchMessages');
Route::post('/messages', 'ChatsController@sendMessage');
Route::get('/messages/{user}', 'ChatsController@show');
Route::post('/messages/{user}', 'ChatsController@create');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/loadchats', 'MessageController@loadchats')->name('loadchats');

Route::get('/userauth', function () {

    return auth()->user();
});

Route::get('allusers', function () {

    return User::all();
});

//avoid refresh error

Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d-\/_.]+)?');
