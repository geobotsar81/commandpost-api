<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Validate the contact form and send the contact email
     *
     * @param Request $request
     * @return Response
     */
    public function sendMail(Request $request): Response
    {
        $validated = $request->validate([
            "name" => "required",
            "email" => "email:rfc,dns",
            "message" => "required",
            "honeypot" => "present|max:0",
        ]);

        $contact = [
            "name" => $request["name"],
            "email" => $request["email"],
            "message" => $request["message"],
        ];

        Mail::to("info@commandpost.dev")->send(new ContactFormMail($contact));
        return response(200);
    }
}
