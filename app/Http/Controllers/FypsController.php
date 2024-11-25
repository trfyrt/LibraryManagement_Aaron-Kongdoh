<?php

namespace App\Http\Controllers;

use App\Models\Fyp;
use App\Models\Fyps;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FypsController extends Controller
{
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
