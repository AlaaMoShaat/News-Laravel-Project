<?php

namespace App\Http\Controllers\Dashboard\Authorization;

use Illuminate\Http\Request;
use App\Models\Authorization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\AuthorizationRequest;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:authorizations');
    }
    public function index()
    {
        $authorizations = Authorization::paginate(5);
        return view('dashboard.authorizations.index', compact('authorizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.authorizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorizationRequest $request)
    {
        $authorization = new Authorization();
        $this->roles($request, $authorization);

        return redirect()->back()->with('success', 'Role Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $authorization = Authorization::findOrFail($id);
        return view('dashboard.authorizations.edit', compact('authorization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorizationRequest $request, string $id)
    {
        $authorization = Authorization::findOrFail($id);
        $this->roles($request, $authorization);
        return redirect()->back()->with('success', 'Role updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Authorization::findOrFail($id);

        if ($role->admins->count() > 0) {
            return redirect()->back()->with('error', 'Please Delete Related Admin first!');
        }
        $role = $role->delete();

        if (!$role) {
            return redirect()->back()->with('error', 'try again latter!');
        }
        return redirect()->back()->with('success', 'Role Deleted Successfully!');
    }

    private function roles($request, $authorization)
    {
        $authorization->role = $request->role;
        $authorization->permessions = json_encode($request->permessions);
        $authorization->save();
    }
}
