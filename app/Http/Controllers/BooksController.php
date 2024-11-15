<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function index() : View{
        $books = Books::latest()->paginate(10);

        return view('librarian.books.index', compact('books'));
    }

    // CREATE
    public function create(): View{
        return view('librarian.books.create');
    }

    public function store(Request $request): RedirectResponse{
        $request->validate([
            'title'      => 'required|min:5',
            'author'     => 'required|min:3',
            'publisher'  => 'required|min:3',
            'year'       => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'type'       => 'required|in:book,ebook',
        ]);

        Books::create([
            'title'      => $request->title,
            'author'     => $request->author,
            'publisher'  => $request->publisher,
            'year'       => $request->year,
            'type'       => $request->type,
        ]);

        return redirect()->route('books.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    // READ
    public function show(string $id): View{
        $book = Books::findOrFail($id);
    
        return view('librarian.books.show', compact('book'));
    }

    // UPDATE
    public function edit(string $id): View{
        $book = Books::findOrFail($id);
    
        return view('librarian.books.edit', compact('book'));
    }

    public function update(Request $request, $id): RedirectResponse{
    $request->validate([
        'title'         => 'required|min:5',
        'author'        => 'required|min:5',
        'publisher'     => 'required|min:5',
        'year'          => 'required|digits:4|integer|min:1900|max:'.date('Y'),
        'type'          => 'required|in:book,ebook',
    ]);

    $book = Books::findOrFail($id);

    $book->update([
        'title'         => $request->title,
        'author'        => $request->author,
        'publisher'     => $request->publisher,
        'year'          => $request->year,
        'type'          => $request->type,
        'is_approved'   => false, //Kalau habis diupdate jadi pending lagi

    ]);

    return redirect()->route('books.index')->with(['success' => 'Book data has been updated successfully!']);
    }

    // DELETE
    public function destroy($id): RedirectResponse{
    $book = Books::findOrFail($id);

    $book->delete();

    return redirect()->route('books.index')->with(['success' => 'Book has been successfully deleted!']);
    }

    // APPROVE
    public function approve($id): RedirectResponse
{
    // Cari buku berdasarkan ID
    $book = Books::findOrFail($id);
    
    // Update status buku menjadi approved
    $book->update([
        'is_approved' => true,
    ]);

    // Redirect ke halaman approval dengan pesan sukses
    return redirect()->route('approval.index')->with(['success' => 'Book data has been updated successfully!']);
}
      
}
