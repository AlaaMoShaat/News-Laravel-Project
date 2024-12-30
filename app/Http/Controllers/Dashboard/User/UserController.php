<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\User;
use App\Utils\ImageManeger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users');
    }
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 2;
        $users = User::when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%')
                ->orWhere('email', 'LIKE', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });
        $users = $users->orderBy($sort_by, $order_by)->paginate($limit_by);
        return view('dashboard.users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        $request->validated();
        try {
            DB::beginTransaction();
            $request->merge([
                'email_verified_at' => $request->email_verified_at == 1 ? now() : null,
            ]);

            $user = User::create($request->except(['_token', 'image', 'password_confirmation']));
            ImageManeger::uploadImage($request, $user);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->back()->with('success', 'User Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:2'],
            'username' => ['required', 'unique:users,username,' . $id], // تجاهل التحقق من تكرار username للمستخدم الحالي
            'email' => ['required', 'unique:users,email,' . $id], // تجاهل التحقق من تكرار email للمستخدم الحالي
            'phone' => ['required', 'unique:users,phone,' . $id], // تجاهل التحقق من تكرار الهاتف للمستخدم الحالي
            'status' => ['in:0,1'],
            'email_verified_at' => ['in:0,1'],
            'country' => ['required', 'string', 'min:2', 'max:20'],
            'city' => ['required', 'string', 'min:2', 'max:30'],
            'street' => ['required', 'string', 'min:2', 'max:30'],
            'password' => ['nullable', 'confirmed'],
            'image' => ['nullable', 'image'], // التحقق من الصورة إذا كانت موجودة
        ]);

        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $request->merge([
                'email_verified_at' => $request->email_verified_at == 1 ? now() : null,
            ]);
            $user->update($request->except(['_token', 'image', 'password_confirmation']));
            ImageManeger::uploadImage($request, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('dashboard.users.index')->with('success', 'User Updated Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        ImageManeger::deleteImageLocaly($user->image);
        $user->delete();

        Session::flash('success', 'User Deleted Suuccessfully!');
        return redirect()->route('dashboard.users.index');
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->status == 1) {
            $user->update([
                'status' => 0,
            ]);
            Session::flash('success', 'User Blocked Suuccessfully!');
        } else {
            $user->update([
                'status' => 1,
            ]);
            Session::flash('success', 'User Active Suuccessfully!');
        }
        return redirect()->back();
    }
}
