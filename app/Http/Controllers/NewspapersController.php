<?php

namespace App\Http\Controllers;

use App\Models\Newspapers;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewspapersController extends Controller
{
    public function index() : View
    {
        $newspapers = Newspapers::latest()->paginate(10);

        return view('newspapers.index', compact('newspapers'));
    }
    public function create(): View
    {
        return view('newspapers.create');
    }
    
}
