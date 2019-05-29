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

//Route::get('/hello', function () {
//    return 'Hello World';
//});


Route::get('/', 'PagesController@index');


Route::get('/lists', 'ListController@index');
Route::get('/lists/{list}','ListController@show');
Route::get('/lists/{list}/practice/{userId}','PracticeController@index')->middleware('CheckUser');
Route::get('/lists/practice/{id}','PracticeController@display');
Route::post('/lists/practice/delete','PracticeController@destroy');
Route::post('/lists/practice/deleteList','PracticeController@deleteList');
Route::post('lists/practice/restart', 'PracticeController@restartModal');
Route::post('lists/practice/update','PracticeController@editModal');
Route::post('/lists/practice/share','PracticeController@share');
Route::post('/lists/practice/checkShare','PracticeController@checkShare');


Route::post('/lists/practice/checked','PracticeController@checked');
Route::post('/lists/practice/onload','PracticeController@onload');
Route::post('/lists/practice/sumCheck','PracticeController@sumCheck');
Route::post('/lists/practice/reset','PracticeController@reset');

Route::get('/dictionary', 'DictionariesController@dictionary');
Route::any('/search', 'DictionariesController@search');

Route::resource('posts', 'PostsController');

Route::any('test','DictionariesController@test');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('users/logout','Auth\LoginController@userLogout')->name('user.logout');

Route::get('user/account','Auth\LoginController@userAccount');
Route::post('user/account/update','Auth\LoginController@updateAccount');


    Route::prefix('admin')->group(function(){
        Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
        Route::get('/logout','Auth\AdminLoginController@logout')->name('admin.logout');
    });
Route::post('/search/store', 'DictionariesController@store');
Route::post('/search/list', 'DictionariesController@showList');
Route::get('/search/dropdown','DictionariesController@ajaxList');
Route::post('/search/destroy','DictionariesController@destroy');

Route::post('/postImage/store','PostImageController@store');
Route::get('/postImage/show','PostImageController@show');
Route::post('/postImage/delete','PostImageController@delete');
Route::post('/postImage/commentInput','PostImageController@inputComment');
Route::post('/postImage/commentGet','PostImageController@getComment');
Route::post('/postImage/commentCount','PostImageController@countComment');

Route::get('/postImage/comment/{postId}','PostImageController@comment');
Route::post('/postImage/like','PostImageController@like');
Route::post('/postImage/reverseLike','PostImageController@reverseLike');

Route::post('/postImage/getLike','PostImageController@getLike');
Route::post('/postImage/update','PostImageController@update');
Route::post('/postImage/restartModal','PostImageController@restartModal');

Route::get('/pagination','PagesController@fetch_data');

Route::get('/postVideo/show','PostVideoController@show');
Route::post('/postVideo/store','PostVideoController@store');
Route::post('/postVideo/delete','PostVideoController@delete');
Route::post('/postVideo/commentCount','PostVideoController@countComment');

Route::post('/postVideo/like','PostVideoController@like');
Route::post('/postVideo/reverseLike','PostVideoController@reverseLike');
Route::post('/postVideo/getLike','PostVideoController@getLike');

Route::get('/postVideo/comment/{postId}','PostVideoController@comment');
Route::post('/postVideo/commentCount','PostVideoController@countComment');
Route::post('/postVideo/commentInput','PostVideoController@inputComment');
Route::post('/postVideo/commentGet','PostVideoController@getComment');

Route::post('/postVideo/update','PostVideoController@update');
Route::post('/postVideo/restartModal','PostVideoController@restartModal');

Route::get('/public/show','ShareToPublicController@show');
