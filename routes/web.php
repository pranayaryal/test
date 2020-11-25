<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Controllers\ImageController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', '\App\Http\Controllers\PostController@getHomePage')->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/contact', '\App\Http\Controllers\PostController@getContactPage')->name('contact');

Route::middleware(['auth:sanctum', 'verified'])->get('/edit', '\App\Http\Controllers\PostController@edit')->name('edit');

Route::middleware(['auth:sanctum', 'verified'])->post('/save', '\App\Http\Controllers\PostController@save')->name('save');

