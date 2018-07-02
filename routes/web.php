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

Route::get('/main', function () {
    return view('welcome');
})->name('main');

Route::get('/leob1', 'ReportController@leob1')->name('leob1');
Route::get('/leob2', 'ReportController@leob2')->name('leob2');
Route::get('/passage', 'ReportController@passage')->name('passage');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
