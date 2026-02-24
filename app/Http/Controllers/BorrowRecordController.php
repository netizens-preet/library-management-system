<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use App\Models\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BorrowRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // app/Http/Controllers/BorrowRecordController.php
public function index()
{
    $query = BorrowRecord::with(['book', 'member']);

    if (Auth::user()->isMember()) {
        // Members only see their own records
        // This assumes your 'members' table has a 'user_id' or matches the user email
        $query->where('member_id', Auth::user()->id); 
    }

    $records = $query->latest()->get();
    
    // Authors get the full list of books to manage, Members just get the catalog
    $books = Book::where('available_copies', '>', 0)->get();

    return view('borrows.index', compact('records', 'books'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = member::where('is_active', true)->get();
    $books = Book::where('available_copies', '>', 0)->get();

    // THIS LINE WAS MISSING:
    return view('borrows.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id'   => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return back()->with('error', 'No copies available.');
        }

        BorrowRecord::create([
            'member_id'   => $request->member_id,
            'book_id'     => $request->book_id,
            'borrowed_at' => now(),
            'due_date'    => now()->addDays(14), // Auto-set 2 week deadline
        ]);

        $book->decrement('available_copies');

        return redirect()->route('borrows.index')->with('success', 'Book issued!');

    }

    /**
     * Display the specified resource.
     */
    public function show(BorrowRecord $borrow_record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BorrowRecord $borrow_record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, BorrowRecord $borrow_record)
{
    if ($borrow_record->returned_at) {
        return back()->with('error', 'Already returned.');
    }

    if (!$borrow_record->book) {
        return back()->with('error', 'Linked book not found in database.');
    }

    $borrow_record->update(['returned_at' => now()]);
    
    $borrow_record->book->increment('available_copies');

    return back()->with('success', 'Book returned!');
}
   
    public function destroy(BorrowRecord $borrow_record)
    {
        if (!$borrow_record->returned_at) {
            $borrow_record->book->increment('available_copies');
        }
        $borrow_record->delete();
        return back()->with('success', 'Record deleted.');
    }
    }

