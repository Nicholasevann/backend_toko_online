<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/about', function () {
//     return 'contact';
// });
// Route::view('/about', 'about', ['name' => 'Nicholas']);

Route::get('/product/{id}', function ($id) {
    return view('product', ['id' => $id]);
});

// Route::get('/contact', function () {
//     return view('contact');
// });

Route::get('/contact/{id}', function ($id) {
    return 'ini adalah id ke' . $id;
});
