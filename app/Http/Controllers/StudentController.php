<?php
namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(): View
    {
        $books = Books::latest()->paginate(10);

        $borrowedBooks = DB::table('borrow')
            ->where('user_id', 3)
            ->pluck('book_id');

        return view('student.borrow.index', compact('books', 'borrowedBooks'));
    }

    public function borrow($id): RedirectResponse
    {
        $book = Books::findOrFail($id);

        DB::table('borrow')->insert([
            'user_id' => 3,
            'book_id' => $book->id,
            'days_left' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('studentBorrow.index')->with(['success' => 'Book borrowed successfully!']);
    }
}
