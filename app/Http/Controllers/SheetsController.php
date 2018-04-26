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

        $sheet->content = $this->updateCell($rowIndex, $columnIndex, $newValue, $sheet->content);
        $sheet->save();
        Pusher::trigger($sheet->channel_name, 'updated', ['change' => $change]);
        return response()->json(['sheet' => $sheet]);
    }

    protected function updateCell($rowIndex, $columnIndex, $newValue, $sheetContent)
    {
        // we expand the sheet to reach the farthest cell
        for ($row = 0; $row <= $rowIndex; $row++) {
            if (!isset($sheetContent[$row])) $sheetContent[$row] = [];
            for ($column = 0; $column <= $columnIndex; $column++) {
                if (!isset($sheetContent[$row][$column])) $sheetContent[$row][$column] = null;
                }
        }
        $sheetContent[$rowIndex][$columnIndex] = $newValue;
        return $sheetContent;
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
