<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Illuminate\Http\Request;
use App\Models\RelatedNewsSite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RelatedSiteController extends Controller
{
    public function index()
    {
        $sites = RelatedNewsSite::latest()->paginate(4);
        return view('dashboard.relatedsites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboad.relatedsites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), RelatedNewsSite::filterRequest());
        if ($validator->fails()) {
            Session::flash('error', 'Enter Valid');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $site = RelatedNewsSite::create($request->only(['name', 'url']));

        Session::flash('success', 'Site Created Successfully');
        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $request->validate(RelatedNewsSite::filterRequest());

        $site = RelatedNewsSite::findOrFail($id);
        $site = $site->update($request->only(['name', 'url']));

        if (!$site) {
            Session::flash('error', 'Try Again Latter!');
            return redirect()->back();
        }
        Session::flash('success', 'Site Updated Successfully');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $site = RelatedNewsSite::findOrFail($id);
        $site->delete();
        Session::flash('success', 'Site Deleted Successfully');
        return redirect()->back();
    }
}