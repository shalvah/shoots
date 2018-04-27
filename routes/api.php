<?php

use App\Models\Sheet;
use Illuminate\Http\Request;

Route::post('sheets/webhook', function (Request $request) {
    $body = $request->post();
    foreach ($body['events'] as $event) {
        if ($event['name'] == 'channel_vacated') {
            $sheetId = str_replace('presence-sheet-', '', $event['channel']);
            $sheet = Sheet::find($sheetId);
            if ($sheet->isEmpty()) {
                $sheet->delete();
            }
        }
        http_response_code(200);
    }});
