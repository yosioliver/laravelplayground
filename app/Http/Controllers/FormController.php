<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        return view('forms.index');
    }

    public function store(Request $request)
    {
        $arrVar = array();
        foreach ($request->input('options') as $options) {
            $form = new Form();
            $arrVar[] = $options;
        }
        $radio = $request['language'];
        return dd($arrVar, $radio);
    }
}
