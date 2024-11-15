<?php

namespace App\Http\Controllers;

use App\Models\Cds;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CdsController extends Controller
{
    public function index() : View
    {
        $cds = Cds::latest()->paginate(10);

        return view('cds.index', compact('cds'));
    }

    public function create(): View
    {
        return view('cds.create');
    }
}
