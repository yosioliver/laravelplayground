<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GosendPartnerController extends Controller
{
    public function hitApi()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => 'mukjayo-engine',
            'Pass-Key' => '00c69441621e6636ebef656bd055e3bf35d9293252843fcdf5461957b6e57e3d'
        ])->get('https://integration-kilat-api.gojekapi.com/gokilat/v10/booking/storeOrderId/AWBfromPartner')->json();
        return dd($response['status']);
    }
}
