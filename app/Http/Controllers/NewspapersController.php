<?php

namespace App\Http\Controllers;

use App\Models\Newspapers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewspapersController extends Controller
{
    public function index(): View
    {
        // Mengambil data latest dan mem-paginate
        $newspapers = Newspapers::latest()->paginate(10);

        return view('newspapers.index', compact('newspapers'));
    }

    // CREATE
    public function create(): View
    {
        return view('newspapers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang masuk
        $request->validate([
            'title'        => 'required|min:5',
            'publisher'    => 'required|min:3',
            'publish_date' => 'required|date',
            'is_available' => 'required|boolean',
        ]);

        // Menyimpan data ke tabel newspapers
        Newspapers::create([
            'title'        => $request->title,
            'publisher'    => $request->publisher,
            'publish_date' => $request->publish_date,
            'is_available' => $request->is_available,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('newspapers.index')->with(['success' => 'Newspaper has been successfully saved!']);
    }

    // READ
    public function show(string $id): View
    {
        // Mencari data newspaper berdasarkan ID
        $newspaper = Newspapers::findOrFail($id);

        return view('newspapers.show', compact('newspaper'));
    }

    // UPDATE
    public function edit(string $id): View
    {
        // Mengambil data newspaper untuk diedit
        $newspaper = Newspapers::findOrFail($id);

        return view('newspapers.edit', compact('newspaper'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi data yang masuk
        $request->validate([
            'title'        => 'required|min:5',
            'publisher'    => 'required|min:3',
            'publish_date' => 'required|date',
            'is_available' => 'required|boolean',
        ]);

        // Mencari data newspaper berdasarkan ID
        $newspaper = Newspapers::findOrFail($id);

        // Memperbarui data
        $newspaper->update([
            'title'        => $request->title,
            'publisher'    => $request->publisher,
            'publish_date' => $request->publish_date,
            'is_available' => $request->is_available,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('newspapers.index')->with(['success' => 'Newspaper has been updated successfully!']);
    }

    // DELETE
    public function destroy($id): RedirectResponse
    {
        // Mencari data newspaper berdasarkan ID
        $newspaper = Newspapers::findOrFail($id);

        // Menghapus data
        $newspaper->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('newspapers.index')->with(['success' => 'Newspaper has been successfully deleted!']);
    }
}
