<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibrarianManagementController extends Controller
{
    public function index(): View
    {
        // Mengambil data latest dan mem-paginate
        $librarians = User::where('level', 'librarian')->paginate(10);

        return view('admin.librarianManagement.index', compact('librarians'));
    }

    // CREATE
    public function create(): RedirectResponse
    {
        return redirect()->route('register');
    }

    // DELETE
    public function destroy($id): RedirectResponse
    {
        // Mencari data newspaper berdasarkan ID
        $librarian = User::findOrFail($id);

        // Menghapus data
        $librarian->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('librarianManagement.index')->with(['success' => 'Librarian has been successfully deleted!']);
    }

}
