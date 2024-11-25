<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CdsController;
use App\Http\Controllers\FypsController;
use App\Http\Controllers\JournalsController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\NewspapersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('/books', \App\Http\Controllers\BooksController::class);
Route::resource('/cds', \App\Http\Controllers\CdsController::class);
Route::resource('/journals', \App\Http\Controllers\JournalsController::class);
Route::resource('/newspapers', \App\Http\Controllers\NewspapersController::class);
Route::resource('/fyps', \App\Http\Controllers\FypsController::class);
Route::resource('/studentBorrow', \App\Http\Controllers\StudentController::class);
Route::resource('/lecturerBorrow', \App\Http\Controllers\LecturerController::class);
Route::resource('/approval', \App\Http\Controllers\ApprovalController::class)->
middleware(['auth', 'admin']);
Route::resource('/librarianManagement', \App\Http\Controllers\LibrarianManagementController::class)->
middleware(['auth', 'admin']);
Route::put('/books/{id}/approve', [BooksController::class, 'approve'])->name('books.approve');
Route::put('/cds/{id}/approve', [CdsController::class, 'approve'])->name('cds.approve');
Route::put('/journals/{id}/approve', [JournalsController::class, 'approve'])->name('journals.approve');
Route::put('/newspapers/{id}/approve', [NewspapersController::class, 'approve'])->name('newspapers.approve');
Route::put('/fyps/{id}/approve', [FypsController::class, 'approve'])->name('fyps.approve');

Route::post('/books/{id}/borrow', [StudentController::class, 'borrow'])->name('books.borrow');
Route::post('/lecturer/borrow/{type}/{id}', [LecturerController::class, 'borrow'])->name('borrow.item');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
