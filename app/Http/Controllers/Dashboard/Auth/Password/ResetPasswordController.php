<?php

namespace App\Http\Controllers\Dashboard\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($email)
    {
        if (!session()->has('password_reset_email') || !session()->has('password_reset_verified')) {
            return redirect()->route('dashboard.password.email')->with('error', 'Please complete the above steps.');
        }

        if (session('password_reset_email') !== $email) {
            return redirect()->route('dashboard.password.email')->with('error', 'Email does not match.');
        }

        return view('dashboard.auth.passwords.reset', compact('email'));
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required']
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->with(['emailError' => 'Try again later']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);
        session()->forget(['password_reset_email', 'password_reset_verified']);

        return redirect()->route('dashboard.login.show')->with('success', 'Your Password Updated Successfully');
    }
}
