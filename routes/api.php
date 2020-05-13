<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user-login', 'UserController@login');

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('/location', 'LocationController');
    Route::resource('/category', 'CategoryController');
    Route::resource('/gallery', 'GalleryController');
    Route::resource('/sub-category', 'SubCategoryController');
    Route::resource('/user', 'UserController');
    Route::resource('/sponsor', 'SponsorController');
    Route::resource('/blog', 'BlogController');
    Route::resource('/blog-gallery', 'BlogGalleryController');

    Route::post('/location/update-custom/{id}', 'LocationController@updateCustom');
    Route::post('/gallery/update-custom/{id}', 'GalleryController@updateCustom');
    Route::post('/sponsor/update-custom/{id}', 'SponsorController@updateCustom');
});

Route::get('/location', 'LocationController@index');
Route::get('/category', 'CategoryController@index');
Route::get('/sponsor', 'SponsorController@index');
Route::get('/blog', 'BlogController@index');