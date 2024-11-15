<?php

namespace App\Http\Controllers;

use App\Models\Journals;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalsController extends Controller
{
    public function index() : View
    {
        $journals = Journals::latest()->paginate(10);

        return view('journals.index', compact('journals'));
    }

    public function create(): View
    {
        return view('journals.create');
    }
}
