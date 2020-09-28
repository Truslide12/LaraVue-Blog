<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

// Admin Routes

    // Tag Routes
        Route::post('app/create_tag', 'AdminController@addTag');
        Route::get('app/get_tags', 'AdminController@getTag');
        Route::post('app/edit_tag', 'AdminController@editTag');
        Route::post('app/delete_tag', 'AdminController@deleteTag');
        Route::post('app/upload', 'AdminController@upload');

    // Category Routes
        Route::post('app/create_category', 'AdminController@addCategory');
        Route::get('app/get_category', 'AdminController@getCategory');
        Route::post('app/edit_category', 'AdminController@editCategory');
        Route::post('app/delete_image', 'AdminController@deleteImage');
        Route::post('app/delete_category', 'AdminController@deleteCategory');

Route::get('/', function () {
    return view('welcome');
});
// example route using controller
Route::get('/new', 'TestController@controllerMethod');

// example of Vue Spa
Route::any('{slug}', function(){
    return view('welcome');
});