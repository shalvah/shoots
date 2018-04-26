<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SheetsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newSheet()
    {
        $user = Auth::user();
        $sheet = Sheet::create([
            'name' => 'Untitled spreadsheet',
            '_users' => [],
            '_owner' => $user->_id,
            'content' => [[]]
        ]);
        $user->push('viewed_sheets', $sheet->_id);
        return redirect(route('sheets.view', ['sheet' => $sheet]));
    }

    public function view(Sheet $sheet)
    {
        return view('spreadsheet', ['sheet' => $sheet]);
    }

    public function update($id)
    {
        $sheet = Sheet::where('_id', $id)->update(['content' => \request('content') ?: [[]]]);
        return response()->json(['sheet' => $sheet]);
    }
}
