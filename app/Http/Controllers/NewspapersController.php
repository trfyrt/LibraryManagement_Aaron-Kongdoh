<?php

namespace App\Http\Controllers;

use App\Models\Newspapers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewspapersController extends Controller
{
        // API: Get all newspapers
        public function apiIndex(): JsonResponse
        {
            $newspapers = Newspapers::latest()->paginate(10);
    
            return response()->json([
                'success' => true,
                'data' => $newspapers,
            ], 200);
        }
    
        // API: Show specific newspaper by ID
        public function apiShow($id): JsonResponse
        {
            $newspaper = Newspapers::find($id);
    
            if (!$newspaper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Newspaper not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $newspaper,
            ], 200);
        }
    
        // API: Create a new newspaper
        public function apiStore(Request $request): JsonResponse
        {
            $validated = $request->validate([
                'title' => 'required|min:5',
                'publisher' => 'required|min:3',
                'publish_date' => 'required|date',
                'is_available' => 'required|boolean',
            ]);
    
            $newspaper = Newspapers::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Newspaper created successfully',
                'data' => $newspaper,
            ], 201);
        }
    
        // API: Update a newspaper
        public function apiUpdate(Request $request, $id): JsonResponse
        {
            $newspaper = Newspapers::find($id);
    
            if (!$newspaper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Newspaper not found',
                ], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|min:5',
                'publisher' => 'required|in:Kompas,Tribun Timur,Fajar',
                'publish_date' => 'required|date',
                'is_available' => 'required|boolean',
            ]);
    
            $newspaper->update(array_merge($validated, ['is_approved' => false]));
    
            return response()->json([
                'success' => true,
                'message' => 'Newspaper updated successfully',
                'data' => $newspaper,
            ], 200);
        }
    
        // API: Delete a newspaper
        public function apiDestroy($id): JsonResponse
        {
            $newspaper = Newspapers::find($id);
    
            if (!$newspaper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Newspaper not found',
                ], 404);
            }
    
            $newspaper->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Newspaper deleted successfully',
            ], 200);
        }
    
    public function index(): View
    {
        // Mengambil data latest dan mem-paginate
        $newspapers = Newspapers::latest()->paginate(10);

        return view('librarian.newspapers.index', compact('newspapers'));
    }

    // CREATE
    public function create(): View
    {
        return view('librarian.newspapers.create');
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

        return view('librarian.newspapers.show', compact('newspaper'));
    }

    // UPDATE
    public function edit(string $id): View
    {
        // Mengambil data newspaper untuk diedit
        $newspaper = Newspapers::findOrFail($id);

        return view('librarian.newspapers.edit', compact('newspaper'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi data yang masuk
        $request->validate([
            'title'        => 'required|min:5',
            'publisher'    => 'required|in:Kompas,Tribun Timur, Fajar',
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
            'is_approved'   => false, //Kalau habis diupdate jadi pending lagi
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
    
    // APPROVE
    public function approve($id): RedirectResponse
{
    // Cari newspaper berdasarkan ID
    $newspaper = Newspapers::findOrFail($id);
    
    // Update status newspaper menjadi approved
    $newspaper->update([
        'is_approved' => true,
    ]);

    // Redirect ke halaman approval dengan pesan sukses
    return redirect()->route('approval.index')->with(['success' => 'Newspaper data has been updated successfully!']);
}

}
