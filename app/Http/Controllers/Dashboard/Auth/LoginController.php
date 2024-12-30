<?php

namespace App\Http\Controllers\Dashboard\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->only(['showLoginForm', 'checkAuth']);
        $this->middleware('auth:admin')->only(['logout']);
    }
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }
    public function show()
    {
        return view('frontend.index');
    }
    public function checkAuth(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'remember' => ['in:on, off']
        ]);
        $auth = Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
        if ($auth) {
            // if admin has permession home -> redirect to home , else redire the first page in his permessions
            $permessions = Auth::guard('admin')->user()->authorization->permessions;
            $first_permession = $permessions[0];


            if (!in_array('home', $permessions)) {
                if (Str::contains($first_permession, 'posts')) {
                    $first_permession = 'posts';
                }
                return redirect()->intended('dashboard/' . $first_permession);
            }
            return redirect()->intended(RouteServiceProvider::DashboardHome);
        } else {
            return redirect()->back()->withErrors(['email' => 'Credentials Dose not match!!']);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard.login.show');
    }
}
