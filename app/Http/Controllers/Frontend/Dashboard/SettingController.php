<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Models\User;
use App\Utils\ImageManeger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // $posts = auth()->user()->posts()->active()->with('images')->latest()->get();
        return view('frontend.dashboard.setting', compact('user'));
    }

    public function update(SettingRequest $request)
    {
        $request->validated();
        $user = User::findOrFail(auth()->user()->id);
        $user->is_profile_complete = true;
        $user->update($request->except(['_token', 'image']));
        $user->save();
        ImageManeger::uploadImage($request, $user);

        return redirect()->route('frontend.dashboard.profile')->with('success', 'Profile Data Updated Successfuly');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Session::flash('error', 'Your current password is incorrect');
            return redirect()->back();
        }
        $user = User::findOrFail(auth()->user()->id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        Session::flash('success', 'Password updated Successfuly');
        return redirect()->back();
    }
}
