<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function show()
    {
        return view('maps.index');
    }
}
