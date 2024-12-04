<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CdsController;
use App\Http\Controllers\FypsController;
use App\Http\Controllers\JournalsController;
use App\Http\Controllers\NewspapersController;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/books', [BooksController::class, 'apiIndex']);
Route::get('/books/{id}', [BooksController::class, 'apiShow']);
Route::post('/books', [BooksController::class, 'apiStore']);
Route::put('/books/{id}', [BooksController::class, 'apiUpdate']);
Route::delete('/books/{id}', [BooksController::class, 'apiDestroy']);

Route::get('/cds', [CdsController::class, 'apiIndex']);
Route::get('/cds/{id}', [CdsController::class, 'apiShow']);
Route::post('/cds', [CdsController::class, 'apiStore']);
Route::put('/cds/{id}', [CdsController::class, 'apiUpdate']);
Route::delete('/cds/{id}', [CdsController::class, 'apiDestroy']);

Route::get('/fyps', [FypsController::class, 'apiIndex']);
Route::get('/fyps/{id}', [FypsController::class, 'apiShow']);
Route::post('/fyps', [FypsController::class, 'apiStore']);
Route::put('/fyps/{id}', [FypsController::class, 'apiUpdate']);
Route::delete('/fyps/{id}', [FypsController::class, 'apiDestroy']);

Route::get('/journals', [JournalsController::class, 'apiIndex']);
Route::get('/journals/{id}', [JournalsController::class, 'apiShow']);
Route::post('/journals', [JournalsController::class, 'apiStore']);
Route::put('/journals/{id}', [JournalsController::class, 'apiUpdate']);
Route::delete('/journals/{id}', [JournalsController::class, 'apiDestroy']);

Route::get('/newspapers', [NewspapersController::class, 'apiIndex']);
Route::get('/newspapers/{id}', [NewspapersController::class, 'apiShow']);
Route::post('/newspapers', [NewspapersController::class, 'apiStore']);
Route::put('/newspapers/{id}', [NewspapersController::class, 'apiUpdate']);
Route::delete('/newspapers/{id}', [NewspapersController::class, 'apiDestroy']);