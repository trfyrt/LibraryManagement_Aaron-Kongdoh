<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BooksController extends Controller
{
        // API: Get all books
        public function apiIndex(): JsonResponse
        {
            $books = Books::all();
    
            return response()->json([
                'success' => true,
                'data' => $books,
            ], 200);
        }
    
        // API: Show specific book by ID
        public function apiShow($id): JsonResponse
        {
            $book = Books::find($id);
    
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $book,
            ], 200);
        }
    
        // API: Create a new book
        public function apiStore(Request $request): JsonResponse
        {
            $validated = $request->validate([
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'publisher' => 'required|min:3',
                'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'type' => 'required|in:book,ebook',
            ]);
    
            $book = Books::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Book created successfully',
                'data' => $book,
            ], 201);
        }
    
        // API: Update a book
        public function apiUpdate(Request $request, $id): JsonResponse
        {
            $book = Books::find($id);
    
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found',
                ], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'publisher' => 'required|min:3',
                'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'type' => 'required|in:book,ebook',
            ]);
    
            $book->update($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully',
                'data' => $book,
            ], 200);
        }
    
        // API: Delete a book
        public function apiDestroy($id): JsonResponse
        {
            $book = Books::find($id);
    
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found',
                ], 404);
            }
    
            $book->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully',
            ], 200);
        }
    
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
