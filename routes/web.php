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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name('register');

Route::resource("users", "UserController");
Route::get('/categories/trash', 'CategoryController@trash')->name('categories.trash');
Route::get('/categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
Route::delete('/categories/{id}/delete-permanent', 'CategoryController@deletePermanent')->name('categories.delete-permanent');


Route::get('/ajax/categories/search', 'CategoryController@ajaxSearch');

Route::resource('categories', 'CategoryController');

Route::resource('books', 'BookController');
Route::get('/barang/trash', 'BarangController@trash')->name('barang.trash');
Route::post('/barang/{id}/restore', 'BarangController@restore')->name('barang.restore');
Route::delete('/barang/{id}/delete-permanent', 'BarangController@deletePermanent')->name('barang.delete-permanent');
Route::resource('barang', 'BarangController');





