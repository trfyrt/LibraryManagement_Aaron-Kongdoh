<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CdsController;
use App\Http\Controllers\JournalsController;
use App\Http\Controllers\NewspapersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('/books', \App\Http\Controllers\BooksController::class);
Route::resource('/cds', \App\Http\Controllers\CdsController::class);
Route::resource('/journals', \App\Http\Controllers\JournalsController::class);
Route::resource('/newspapers', \App\Http\Controllers\NewspapersController::class);
Route::resource('/approval', \App\Http\Controllers\ApprovalController::class)->
middleware(['auth', 'admin']);
Route::resource('/librarianManagement', \App\Http\Controllers\LibrarianManagementController::class)->
middleware(['auth', 'admin']);
Route::put('/books/{id}/approve', [BooksController::class, 'approve'])->name('books.approve');
Route::put('/cds/{id}/approve', [CdsController::class, 'approve'])->name('cds.approve');
Route::put('/journals/{id}/approve', [JournalsController::class, 'approve'])->name('journals.approve');
Route::put('/newspapers/{id}/approve', [NewspapersController::class, 'approve'])->name('newspapers.approve');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
