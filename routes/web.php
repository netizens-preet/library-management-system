<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowRecordController;

// Default Landing Page
Route::get('/', function () {
    return view('home'); // Your dashboard view
})->name('dashboard');
// 1. Authors CRUD
// Routes: authors.index, authors.create, authors.store, authors.edit, authors.update, authors.destroy
Route::resource('authors', AuthorController::class);

// 2. Books CRUD
// Routes: books.index, books.create, etc.
Route::resource('books', BookController::class);

// 3. Members CRUD
// Note: 'destroy' here handles our deactivation logic (is_active = false)
Route::resource('members', MemberController::class);

// 4. Borrowing System CRUD
// This handles the specialized inventory logic we built
Route::resource('borrows', BorrowRecordController::class);

// Special Route for Returning a Book
// Since returning is a specific update to a borrow record, we use PATCH or PUT
Route::patch('/borrows/{borrow}/return', [BorrowRecordController::class, 'update'])->name('borrows.return');