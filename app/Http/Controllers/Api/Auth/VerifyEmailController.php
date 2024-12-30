<?php

namespace App\Http\Controllers\Api\Auth;

use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpVerifyUserEmail;
use App\Notifications\SendCodeVerifyUserEmail;

class VerifyEmailController extends Controller
{
    protected $code;
    public function __construct()
    {
        $this->code = new Otp();
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['token' => ['required', 'max:8']]);
        $user = $request->user(); //from sanctum token

        $code2 = $this->code->validate($user->email, $request->token); // هل التوكين تابع لهذا الايميل؟
        if ($code2->status == false) {
            return apiResponse(400, 'Code is invalid');
        }
        $user->update(['email_verified_at' => now()]);
        return apiResponse(200, 'Email Verified successfully');
    }

    public function sendCodeAgain()
    {
        $user = request()->user();
        $user->notify(new SendCodeVerifyUserEmail());
        return apiResponse(200, 'Code Send Again Successfully!');
    }
}