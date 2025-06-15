<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GosendPartnerController extends Controller
{
    public function hitApiGet()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => 'mukjayo-engine',
            'Pass-Key' => '00c69441621e6636ebef656bd055e3bf35d9293252843fcdf5461957b6e57e3d'
        ])->get('https://integration-kilat-api.gojekapi.com/gokilat/v10/booking/storeOrderId/AWBfromPartner')->json();
        return dd($response['status']);
    }

    public function hitApiPost()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => 'mukjayo-engine',
            'Pass-Key' => '00c69441621e6636ebef656bd055e3bf35d9293252843fcdf5461957b6e57e3d'
        ])->post('https://integration-kilat-api.gojekapi.com/gokilat/v10/booking',
            [
                "paymentType" => 3,
                "shipment_method" => "Instant",
                "routes" => [
                    [
                        "originName" => "Pak Andri",
                        "originNote" => "Tunggu Di Lobby",
                        "originContactName" => "The Kingdom Shop",
                        "originContactPhone" => "6285201311802",
                        "originLatLong" => "-6.1263348,106.7890888",
                        "originAddress" => "Jalan Pancoran Buntu I, Pancoran, 12780, Note origin example blablablaxhsdhs",
                        "destinationName" => "Pak Nando",
                        "destinationNote" => "Tolong Hati-Hati",
                        "destinationContactName" => "Toko Jaya Agung",
                        "destinationContactPhone" => "6281254564161",
                        "destinationLatLong" => "-6.284508001748839,106.8295789",
                        "destinationAddress" => "Jalan Jatianom, Pasar Minggu, 12540, Note destination example",
                        "item" => "Sepatu, Sendal, Kaos Kaki",
                        "storeOrderId" => "AWBfromPartner",
                        "insuranceDetails" => [
                            "applied" => "false",
                            "fee" => "0",
                            "product_description" => "Sepatu, Sendal, Kaos Kaki",
                            "product_price" => "500.000"
                        ]
                    ]
                ]
            ])->json();
        return dd($response['orderNo']);
    }

    public function hitApiEstimateGet()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => 'mukjayo-engine',
            'Pass-Key' => '00c69441621e6636ebef656bd055e3bf35d9293252843fcdf5461957b6e57e3d'
        ])->get('https://integration-kilat-api.gojekapi.com/gokilat/v10/calculate/price?origin=-6.254199%2C106.801546&destination=-6.199508%2C106.832607',
            )->json();
        return dd($response['Instant']['price']['total_price']);
    }
}
