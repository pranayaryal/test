<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', [PostController::class, 'getHomePage'])->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/contact', [ContactController::class, 'show'])->name('contact');

Route::middleware(['auth:sanctum', 'verified'])->get('/edit-home', [PostController::class, 'edit'])->name('editHome');
Route::middleware(['auth:sanctum', 'verified'])->get('/edit-contact', [ContactController::class, 'edit'])->name('editContact');

Route::middleware(['auth:sanctum', 'verified'])->post('/save-home', [PostController::class, 'save'])->name('saveHome');
Route::middleware(['auth:sanctum', 'verified'])->post('/save-contact', [ContactController::class, 'save'])->name('saveContact');

Route::middleware(['auth:sanctum', 'verified'])->post('/delete-home-photo', [PostController::class, 'deletePhoto'])->name('homePhotoDelete');
Route::middleware(['auth:sanctum', 'verified'])->post('/delete-contact-photo', [ContactController::class, 'deletePhoto'])->name('contactPhotoDelete');
Route::middleware(['auth:sanctum', 'verified'])->post('/delete-post', '\App\Http\Controllers\PostController@deletePost')->name('deletePost');
Route::middleware(['auth:sanctum', 'verified'])->post('/contact', [ContactController::class, 'postContact'])->name('contact.post');

