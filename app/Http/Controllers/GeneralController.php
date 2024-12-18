<?php
namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function index(): View
    {
        $books = Books::latest()->paginate(10);

        $borrowedBooks = DB::table('borrow')
            ->where('user_id', 5)
            ->pluck('book_id');

        return view('general.borrow.index', compact('books', 'borrowedBooks'));
    }

    public function borrow($id): RedirectResponse
    {
        $book = Books::findOrFail($id);

        DB::table('borrow')->insert([
            'user_id' => 5,
            'book_id' => $book->id,
            'days_left' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('generalBorrow.index')->with(['success' => 'Book borrowed successfully!']);
    }
}
