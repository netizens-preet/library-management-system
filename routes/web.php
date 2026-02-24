<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Default Landing Page
Route::get('/', function () {
    return view('home'); // Your dashboard view
})->name('dashboard');

// 1. Authors CRUD
Route::resource('authors', AuthorController::class);

// 2. Books CRUD
Route::resource('books', BookController::class);

// 3. Members CRUD
Route::resource('members', MemberController::class);

// 4. Borrowing System CRUD
Route::resource('borrows', BorrowRecordController::class);

// Special Route for Returning a Book
Route::patch('/borrows/{borrow}/return', [BorrowRecordController::class, 'update'])->name('borrows.return');

// Breeze Dashboard (Optional: You can redirect or merge this with your original logic)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('breeze.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Only Authors can access these
// Only Authenticated and Verified users
Route::middleware(['auth', 'verified'])->group(function () {
    
    // AUTHOR ONLY: Can manage Authors and Books
    Route::middleware('role:author')->group(function () {
        Route::resource('authors', AuthorController::class);
        // This creates books.index, books.create, books.store, etc.
        Route::resource('books', BookController::class);
    });

    // MEMBER ONLY: Can only view catalog and borrow
    Route::middleware('role:member')->group(function () {
        // We use a different name to avoid route collision
        Route::get('/catalog', [BookController::class, 'index'])->name('member.catalog');
        Route::post('/borrow', [BorrowRecordController::class, 'store'])->name('borrows.store');
    });
});