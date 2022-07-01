<?php

use App\Models\Teacher;
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

Route::get('/', 'SiteController@index');
Route::get('/all', 'SiteController@show');
Route::post('/card/update/next', 'SiteController@cardUpdateNext');
//Route::post('/card/update/previous', 'SiteController@cardUpdatePrevious');
Route::get('/search', 'SearchController@search');