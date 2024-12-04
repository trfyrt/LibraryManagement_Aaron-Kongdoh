<?php

namespace App\Http\Controllers;

use App\Models\Cds;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CdsController extends Controller
{
        // API: Get all CDs
        public function apiIndex(): JsonResponse
        {
            $cds = Cds::all();
    
            return response()->json([
                'success' => true,
                'data' => $cds,
            ], 200);
        }
    
        // API: Show specific CD by ID
        public function apiShow($id): JsonResponse
        {
            $cd = Cds::find($id);
    
            if (!$cd) {
                return response()->json([
                    'success' => false,
                    'message' => 'CD not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $cd,
            ], 200);
        }
    
        // API: Create a new CD
        public function apiStore(Request $request): JsonResponse
        {
            $validated = $request->validate([
                'title' => 'required|min:5',
                'artist' => 'required|min:3',
                'genre' => 'required|min:3',
                'stock' => 'required|integer|min:0',
            ]);
    
            $cd = Cds::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'CD created successfully',
                'data' => $cd,
            ], 201);
        }
    
        // API: Update a CD
        public function apiUpdate(Request $request, $id): JsonResponse
        {
            $cd = Cds::find($id);
    
            if (!$cd) {
                return response()->json([
                    'success' => false,
                    'message' => 'CD not found',
                ], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|min:5',
                'artist' => 'required|min:3',
                'genre' => 'required|min:3',
                'stock' => 'required|integer|min:0',
            ]);
    
            $cd->update(array_merge($validated, ['is_approved' => false]));
    
            return response()->json([
                'success' => true,
                'message' => 'CD updated successfully',
                'data' => $cd,
            ], 200);
        }
    
        // API: Delete a CD
        public function apiDestroy($id): JsonResponse
        {
            $cd = Cds::find($id);
    
            if (!$cd) {
                return response()->json([
                    'success' => false,
                    'message' => 'CD not found',
                ], 404);
            }
    
            $cd->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'CD deleted successfully',
            ], 200);
        }

    public function index(): View
    {
        $cds = Cds::latest()->paginate(10);

        return view('librarian.cds.index', compact('cds'));
    }

    // CREATE
    public function create(): View
    {
        return view('librarian.cds.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'     => 'required|min:5',
            'artist'    => 'required|min:3',
            'genre'     => 'required|min:3',
            'stock'     => 'required|integer|min:0',
        ]);

        Cds::create([
            'title'     => $request->title,
            'artist'    => $request->artist,
            'genre'     => $request->genre,
            'stock'     => $request->stock,
        ]);

        return redirect()->route('cds.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    // READ
    public function show(string $id): View
    {
        $cd = Cds::findOrFail($id);

        return view('librarian.cds.show', compact('cd'));
    }

    // UPDATE
    public function edit(string $id): View
    {
        $cd = Cds::findOrFail($id);

        return view('librarian.cds.edit', compact('cd'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title'     => 'required|min:5',
            'artist'    => 'required|min:3',
            'genre'     => 'required|min:3',
            'stock'     => 'required|integer|min:0',
        ]);

        $cd = Cds::findOrFail($id);

        $cd->update([
            'title'     => $request->title,
            'artist'    => $request->artist,
            'genre'     => $request->genre,
            'stock'     => $request->stock,
            'is_approved'   => false, //Kalau habis diupdate jadi pending lagi
        ]);

        return redirect()->route('cds.index')->with(['success' => 'Cds data has been updated successfully!']);
    }

    // DELETE
    public function destroy($id): RedirectResponse
    {
        $cd = Cds::findOrFail($id);

        $cd->delete();

        return redirect()->route('cds.index')->with(['success' => 'Cds has been successfully deleted!']);
    }

    // APPROVE
    public function approve($id): RedirectResponse
{
    // Cari CD berdasarkan ID
    $cd = Cds::findOrFail($id);
    
    // Update status CD menjadi approved
    $cd->update([
        'is_approved' => true,
    ]);

    // Redirect ke halaman approval dengan pesan sukses
    return redirect()->route('approval.index')->with(['success' => 'CD data has been updated successfully!']);
}

}
