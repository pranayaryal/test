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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia\Inertia::render('Home', [
        'home_page_html' => Page::where('name', 'home')->first()->html,
        'image_path' => '../img/front.jpg'
    ]);
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/contact', function () {
    return Inertia\Inertia::render('Contact/Show', [
        'image_path' => '../img/contact.jpg'
    ]);
})->name('contact');

Route::middleware(['auth:sanctum', 'verified'])->get('/edit', function () {
    return Inertia\Inertia::render('Edit/Show', [
        'page' => Page::where('name', 'home')->first()->html,
    ]);
})->name('edit');

Route::get('/testingPage', function(){
    $page = Page::all()->first();
    dd($page);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/quill', function () {
    return Inertia\Inertia::render('Edit/TestingQuill', [
        'page' => Page::where('name', 'home')->first()->html,
    ]);
})->name('quill');


Route::middleware(['auth:sanctum', 'verified'])->get('/check', function () {
    $page = Page::where('name', 'home')->first()->html;
    dd($page);

})->name('check');


Route::middleware(['auth:sanctum', 'verified'])->post('/save', '\App\Http\Controllers\PostController@save')->name('save');

