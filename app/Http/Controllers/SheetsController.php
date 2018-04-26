<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Laravel\Facades\Pusher;

class SheetsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newSheet()
    {
        $sheet = Sheet::create([
            'name' => 'Untitled spreadsheet',
            '_owner' => Auth::user()->_id,
            'content' => [[]]
        ]);
        return redirect(route('sheets.view', ['sheet' => $sheet]));
    }

    public function view(Sheet $sheet)
    {
        Auth::user()->push('viewed_sheets', $sheet->_id);
        return view('spreadsheet', ['sheet' => $sheet]);
    }

    public function update($id)
    {
        $sheet = Sheet::findOrFail($id);
        $change = \request('change');
        [$rowIndex, $columnIndex, $oldValue, $newValue] = $change;

        $sheetContent = $sheet->content;
        $sheetContent[$rowIndex][$columnIndex] = $newValue;
        $sheet->content = $sheetContent;
        $sheet->save();
        Pusher::trigger($sheet->channel_name, 'updated', ['change' => $change]);
        return response()->json(['sheet' => $sheet]);
    }

    public function authenticateForSubscription($id)
    {
        $authSignature = Pusher::presence_auth(
            \request('channel_name'),
            \request('socket_id'),
            \Auth::user()->_id,
            \Auth::user()->toArray()
        );
        return response()->json(json_decode($authSignature));
    }
}
