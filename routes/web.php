<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/books', \App\Http\Controllers\BooksController::class);
Route::resource('/cds', \App\Http\Controllers\CdsController::class);
Route::resource('/journals', \App\Http\Controllers\JournalsController::class);
Route::resource('/newspapers', \App\Http\Controllers\NewspapersController::class);