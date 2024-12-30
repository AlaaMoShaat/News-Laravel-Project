<?php

namespace App\Http\Controllers\Dashboard\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\SendCodeNotify;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public $code2;
    public function __construct()
    {
        $this->code2 = new Otp;
    }
    public function showEmailForm()
    {
        return view('dashboard.auth.passwords.email');
    }

    public function sendCode(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->withErrors(['email' => 'Try Again Latter']);
        }
        $admin->notify(new SendCodeNotify());
        session(['password_reset_email' => $admin->email]);
        return redirect()->route('dashboard.password.showCodeForm', ['email' => $admin->email]);
    }

    public function showCodeForm($email)
    {
        return view('dashboard.auth.passwords.confirm', compact('email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'min:5']
        ]);

        $code = $this->code2->validate($request->email, $request->token);
        if (!$code->status) {
            return redirect()->back()->withErrors(['token' => 'Code is Invalid!']);
        }
        session(['password_reset_verified' => true]);

        return redirect()->route('dashboard.password.showResetForm', ['email' => $request->email]);
    }
}
