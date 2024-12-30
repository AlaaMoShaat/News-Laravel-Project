<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\NewSubscriber;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\Frontend\NewSubscriberMail;

class NewsSubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:new_subscribers,email']
        ]);

        $newSubscriber = NewSubscriber::create([
            'email' => $request->email,
        ]);

        if (!$newSubscriber) {
            Session::flash('error', 'Sorry Try again letter');
            return redirect()->back();
        }
        Mail::to($request->email)->send(new NewSubscriberMail());
        Session::flash('success', 'Thanks for Subscribe');
        return redirect()->back();
    }
}
