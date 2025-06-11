<?php

namespace App\Http\Controllers;

use App\Mail\MyTestEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $mailData = [
            'title' => 'Mail from Test',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('yosioliver@gmail.com')->send(new MyTestEmail($mailData));
        dd("Email is sent successfully.");
    }
}
