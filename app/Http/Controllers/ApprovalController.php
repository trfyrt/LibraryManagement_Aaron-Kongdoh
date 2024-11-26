<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Cds;
use App\Models\Fyps;
use App\Models\Journals;
use App\Models\Newspapers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function index(): View{
    $books = Books::where('is_approved', false)->latest()->paginate(10);
    $cds = Cds::where('is_approved', false)->latest()->paginate(10);
    $newspapers = Newspapers::where('is_approved', false)->latest()->paginate(10);
    $journals = Journals::where('is_approved', false)->latest()->paginate(10);
    $fyps = Fyps::where('is_approved', false)->latest()->paginate(10);

    return view('admin.approval.index', compact('books', 'cds', 'newspapers', 'journals', 'fyps'));
    }
}
