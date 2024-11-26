<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Cds;
use App\Models\Fyps;
use App\Models\Journals;
use App\Models\Newspapers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LecturerController extends Controller
{
    public function index(): View
    {
        $books = Books::latest()->paginate(10);
        $cds = Cds::latest()->paginate(10);
        $fyps = Fyps::latest()->paginate(10);
        $journals = Journals::latest()->paginate(10);
        $newspapers = Newspapers::latest()->paginate(10);

        $borrowedItems = DB::table('borrow')
            ->where('user_id', 4)
            ->get(['book_id', 'cd_id', 'fyp_id', 'journal_id', 'newspaper_id']);

        return view('lecturer.borrow.index', compact('books', 'cds', 'fyps', 'journals', 'newspapers', 'borrowedItems'));
    }

    public function borrow(Request $request, $type, $id): RedirectResponse
    {
        $data = [
            'user_id' => 4,
            'days_left' => $request->input('days_left', 3),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        switch ($type) {
            case 'book':
                $data['book_id'] = $id;
                break;
            case 'cd':
                $data['cd_id'] = $id;
                break;
            case 'fyp':
                $data['fyp_id'] = $id;
                break;
            case 'journal':
                $data['journal_id'] = $id;
                break;
            case 'newspaper':
                $data['newspaper_id'] = $id;
                break;
            default:
                return redirect()->back()->with(['error' => 'Invalid item type.']);
        }

        DB::table('borrow')->insert($data);

        return redirect()->route('lecturerBorrow.index')->with(['success' => ucfirst($type) . ' borrowed successfully!']);
    }
}
