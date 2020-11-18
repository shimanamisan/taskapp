<?php

namespace App\Http\Controllers;

use App\Mail\Contact; // 追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // 追加
use App\Http\Requests\ContactRequest; // 追加

class ContactController extends Controller
{
    public function postMessage(ContactRequest $request)
    {
        $contact = $request->all();

        $request->session()->regenerateToken();

        Mail::to("itsup-info@shimanamisan.com")->send(new Contact($contact));

        return response()->json(["success"], 200);
    }
}
