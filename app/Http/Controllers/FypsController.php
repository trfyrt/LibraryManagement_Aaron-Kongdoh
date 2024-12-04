<?php

namespace App\Http\Controllers;

use App\Models\Fyp;
use App\Models\Fyps;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FypsController extends Controller
{
        // API: Get all FYPs
        public function apiIndex(): JsonResponse
        {
            $fyps = Fyps::all();
    
            return response()->json([
                'success' => true,
                'data' => $fyps,
            ], 200);
        }
    
        // API: Show specific FYP by ID
        public function apiShow($id): JsonResponse
        {
            $fyp = Fyps::find($id);
    
            if (!$fyp) {
                return response()->json([
                    'success' => false,
                    'message' => 'FYP not found',
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $fyp,
            ], 200);
        }
    
        // API: Create a new FYP
        public function apiStore(Request $request): JsonResponse
        {
            $validated = $request->validate([
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'supervisor' => 'required|min:3',
                'year' => 'required|integer|digits:4',
            ]);
    
            $fyp = Fyps::create($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'FYP created successfully',
                'data' => $fyp,
            ], 201);
        }
    
        // API: Update an FYP
        public function apiUpdate(Request $request, $id): JsonResponse
        {
            $fyp = Fyps::find($id);
    
            if (!$fyp) {
                return response()->json([
                    'success' => false,
                    'message' => 'FYP not found',
                ], 404);
            }
    
            $validated = $request->validate([
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'supervisor' => 'required|min:3',
                'year' => 'required|integer|digits:4',
            ]);
    
            $fyp->update(array_merge($validated, ['is_approved' => false]));
    
            return response()->json([
                'success' => true,
                'message' => 'FYP updated successfully',
                'data' => $fyp,
            ], 200);
        }
    
        // API: Delete an FYP
        public function apiDestroy($id): JsonResponse
        {
            $fyp = Fyps::find($id);
    
            if (!$fyp) {
                return response()->json([
                    'success' => false,
                    'message' => 'FYP not found',
                ], 404);
            }
    
            $fyp->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'FYP deleted successfully',
            ], 200);
        }
    
    public function index(): View
    {
        // Retrieve FYPs with pagination
        $fyps = Fyps::latest()->paginate(10);

        return view('librarian.fyps.index', compact('fyps'));
    }

    // CREATE
    public function create(): View
    {
        return view('librarian.fyps.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the input data
        $request->validate([
            'title'       => 'required|min:5',
            'author'      => 'required|min:3',
            'supervisor'  => 'required|min:3',
            'year'        => 'required|integer|digits:4',
        ]);

        // Create a new FYP entry
        Fyps::create([
            'title'       => $request->title,
            'author'      => $request->author,
            'supervisor'  => $request->supervisor,
            'year'        => $request->year,
        ]);

        // Redirect back with a success message
        return redirect()->route('fyps.index')->with(['success' => 'FYP data has been saved successfully!']);
    }

    // READ
    public function show(string $id): View
    {
        // Find the FYP by its ID
        $fyp = Fyps::findOrFail($id);

        return view('librarian.fyps.show', compact('fyp'));
    }

    // UPDATE
    public function edit(string $id): View
    {
        // Find the FYP by its ID
        $fyp = Fyps::findOrFail($id);

        return view('librarian.fyps.edit', compact('fyp'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the input data
        $request->validate([
            'title'       => 'required|min:5',
            'author'      => 'required|min:3',
            'supervisor'  => 'required|min:3',
            'year'        => 'required|integer|digits:4',
        ]);

        // Find the FYP by its ID and update
        $fyp = Fyps::findOrFail($id);

        $fyp->update([
            'title'       => $request->title,
            'author'      => $request->author,
            'supervisor'  => $request->supervisor,
            'year'        => $request->year,
            'is_approved' => false, // Reset approval status
        ]);

        // Redirect back with a success message
        return redirect()->route('fyps.index')->with(['success' => 'FYP data has been updated successfully!']);
    }

    // DELETE
    public function destroy($id): RedirectResponse
    {
        // Find the FYP by its ID and delete it
        $fyp = Fyps::findOrFail($id);

        $fyp->delete();

        // Redirect back with a success message
        return redirect()->route('fyps.index')->with(['success' => 'FYP has been successfully deleted!']);
    }

    // APPROVE
    public function approve($id): RedirectResponse
    {
        // Find the FYP by its ID
        $fyp = Fyps::findOrFail($id);

        // Update the FYP to be approved
        $fyp->update([
            'is_approved' => true,
        ]);

        // Redirect back with a success message
        return redirect()->route('approval.index')->with(['success' => 'FYP has been approved successfully!']);
    }
}
