<?php

namespace App\Http\Controllers;

use App\Models\Journals;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalsController extends Controller
{
        // API: Get all journals
        public function apiIndex(): JsonResponse
        {
            $journals = Journals::latest()->paginate(10);
    
            return response()->json([
                'success' => true,
                'data' => $journals,
            ], 200);
        }
    
        // API: Show specific journal by ID
        public function apiShow($id): JsonResponse
        {
            $journal = Journals::find($id);
    
            if (!$journal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Journal not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $journal,
            ], 200);
        }
    
        // API: Create a new journal
        public function apiStore(Request $request): JsonResponse
        {
            $validated = $request->validate([
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'publish_date' => 'required|date',
                'abstract' => 'required|min:10',
            ]);
    
            $journal = Journals::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Journal created successfully',
                'data' => $journal,
            ], 201);
        }
    
        // API: Update a journal
        public function apiUpdate(Request $request, $id): JsonResponse
        {
            $journal = Journals::find($id);
    
            if (!$journal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Journal not found',
                ], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'publish_date' => 'required|date',
                'abstract' => 'required|min:10',
            ]);
    
            $journal->update(array_merge($validated, ['is_approved' => false]));
    
            return response()->json([
                'success' => true,
                'message' => 'Journal updated successfully',
                'data' => $journal,
            ], 200);
        }
    
        // API: Delete a journal
        public function apiDestroy($id): JsonResponse
        {
            $journal = Journals::find($id);
    
            if (!$journal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Journal not found',
                ], 404);
            }
    
            $journal->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Journal deleted successfully',
            ], 200);
        }
    
    public function index(): View
    {
        // Retrieve journals with pagination
        $journals = Journals::latest()->paginate(10);

        return view('librarian.journals.index', compact('journals'));
    }

    // CREATE
    public function create(): View
    {
        return view('librarian.journals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the input data
        $request->validate([
            'title'        => 'required|min:5',
            'author'       => 'required|min:3',
            'publish_date' => 'required|date',
            'abstract'     => 'required|min:10',
        ]);

        // Create a new journal entry
        Journals::create([
            'title'        => $request->title,
            'author'       => $request->author,
            'publish_date' => $request->publish_date,
            'abstract'     => $request->abstract,
        ]);

        // Redirect back with a success message
        return redirect()->route('journals.index')->with(['success' => 'Journal data has been saved successfully!']);
    }

    // READ
    public function show(string $id): View
    {
        // Find the journal by its ID
        $journal = Journals::findOrFail($id);

        return view('librarian.journals.show', compact('journal'));
    }

    // UPDATE
    public function edit(string $id): View
    {
        // Find the journal by its ID
        $journal = Journals::findOrFail($id);

        return view('librarian.journals.edit', compact('journal'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the input data
        $request->validate([
            'title'        => 'required|min:5',
            'author'       => 'required|min:3',
            'publish_date' => 'required|date',
            'abstract'     => 'required|min:10',
        ]);

        // Find the journal by its ID and update
        $journal = Journals::findOrFail($id);

        $journal->update([
            'title'        => $request->title,
            'author'       => $request->author,
            'publish_date' => $request->publish_date,
            'abstract'     => $request->abstract,
            'is_approved'   => false, //Kalau habis diupdate jadi pending lagi
        ]);

        // Redirect back with a success message
        return redirect()->route('journals.index')->with(['success' => 'Journal data has been updated successfully!']);
    }

    // DELETE
    public function destroy($id): RedirectResponse
    {
        // Find the journal by its ID and delete it
        $journal = Journals::findOrFail($id);

        $journal->delete();

        // Redirect back with a success message
        return redirect()->route('journals.index')->with(['success' => 'Journal has been successfully deleted!']);
    }

    // APPROVE
    public function approve($id): RedirectResponse
{
    // Cari jurnal berdasarkan ID
    $journal = Journals::findOrFail($id);
    
    // Update status jurnal menjadi approved
    $journal->update([
        'is_approved' => true,
    ]);

    // Redirect ke halaman approval dengan pesan sukses
    return redirect()->route('approval.index')->with(['success' => 'Journal data has been updated successfully!']);
}

}
