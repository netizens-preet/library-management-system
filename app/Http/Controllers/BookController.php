<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->latest()->get();
        
        return view('books.index', compact('books') );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::orderBy('name')->get();
    return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title'            => 'required|string|max:255',
        'author_id'        => 'required|exists:authors,id',
        'published_year'   => 'required|integer|min:1000|max:' . (date('Y') + 1),
        'total_copies'     => 'required|integer|min:1',
        'available_copies' => 'required|integer|min:0|max:' . $request->total_copies,
    ]);

    // This now includes published_year from the form
    Book::create($request->all());

    return redirect()->route('books.index')->with('success', 'Book registered successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'available_copies' => 'required|integer|min:0',
        ]);
        $book->update($validated);
        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted!');
    }
}
