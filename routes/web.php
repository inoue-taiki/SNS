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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');
//Route::post('/register', 'Auth\RegisterController@validator');

Route::get('/added', 'Auth\RegisterController@added');



//ログイン中のページ
Route::get('/top','PostsController@index');
Route::post('/post/create','PostsController@create');

//編集・更新のルーティング
Route::post('/post/update', 'PostsController@update');

//削除のルーティング
Route::get('post/{id}/delete', 'PostsController@delete');


Route::get('/logout','Auth\LoginController@logout');
Route::get('/profile','UsersController@profile');

//検索
Route::get('/users/search','UsersController@search');
Route::post('/users/search','UsersController@search');

//フォローする
Route::get('/users/{id}/follow','UsersController@follow');

//フォローを外す
Route::get('/follows/{id}/unfollow','UsersController@unfollow');


//フォローリスト
Route::get('/follow-list','PostsController@index');
Route::get('/follow-list','FollowsController@followList');

//フォロワーリスト
Route::get('/follower-list','PostsController@index');
Route::get('/follower-list','FollowsController@followerList');


//プロフィール
Route::get('/users.profile','UsersController@profile');
Route::post('/profileEdit','UsersController@update');
//プロフィールの中の画像更新
Route::post('/file_upload','UsersController@update');


//相手ユーザープロフィール
Route::get('/other/profile/{id}','FollowsController@other_profile');//フォローリストの情報を相手プロフィール画面に引き継ぐ
Route::get('/other/profile','UsersController@follow');
Route::get('/other/profile','UsersController@unfollow');




