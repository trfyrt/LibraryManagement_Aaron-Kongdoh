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

// Middleware group untuk librarian
Route::middleware(['auth', 'librarian'])->group(function () {
    Route::resource('/books', \App\Http\Controllers\BooksController::class);
    Route::resource('/cds', \App\Http\Controllers\CdsController::class);
    Route::resource('/journals', \App\Http\Controllers\JournalsController::class);
    Route::resource('/newspapers', \App\Http\Controllers\NewspapersController::class);
    Route::resource('/fyps', \App\Http\Controllers\FypsController::class);
});

// Middleware group untuk student
Route::middleware(['auth', 'student'])->group(function () {
    Route::resource('/studentBorrow', \App\Http\Controllers\StudentController::class);
    Route::post('/books/{id}/borrow', [StudentController::class, 'borrow'])->name('books.borrow');
});

// Middleware group untuk lecturer
Route::middleware(['auth', 'lecturer'])->group(function () {
    Route::resource('/lecturerBorrow', \App\Http\Controllers\LecturerController::class);
    Route::post('/lecturer/borrow/{type}/{id}', [LecturerController::class, 'borrow'])->name('borrow.item');
});

// Middleware group untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/approval', \App\Http\Controllers\ApprovalController::class);
    Route::resource('/librarianManagement', \App\Http\Controllers\LibrarianManagementController::class);
    Route::put('/books/{id}/approve', [BooksController::class, 'approve'])->name('books.approve');
    Route::put('/cds/{id}/approve', [CdsController::class, 'approve'])->name('cds.approve');
    Route::put('/journals/{id}/approve', [JournalsController::class, 'approve'])->name('journals.approve');
    Route::put('/newspapers/{id}/approve', [NewspapersController::class, 'approve'])->name('newspapers.approve');
    Route::put('/fyps/{id}/approve', [FypsController::class, 'approve'])->name('fyps.approve');
});


Route::get('/dashboard', function () {
    return redirect()->route('approval.index');
})->middleware(['auth', 'admin']);

Route::get('/dashboard', function () {
    return redirect()->route('books.index');
})->middleware(['auth', 'librarian']);

Route::get('/dashboard', function () {
    return redirect()->route('lecturerBorrow.index');
})->middleware(['auth', 'lecturer']);

Route::get('/dashboard', function () {
    return redirect()->route('studentBorrow.index');
})->middleware(['auth', 'student']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
