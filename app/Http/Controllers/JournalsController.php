<?php

namespace App\Http\Controllers;

use App\Models\Journals;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalsController extends Controller
{
    public function index(): View
    {
        // Retrieve journals with pagination
        $journals = Journals::latest()->paginate(10);

        return view('journals.index', compact('journals'));
    }

    // CREATE
    public function create(): View
    {
        return view('journals.create');
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

        return view('journals.show', compact('journal'));
    }

    // UPDATE
    public function edit(string $id): View
    {
        // Find the journal by its ID
        $journal = Journals::findOrFail($id);

        return view('journals.edit', compact('journal'));
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
}
