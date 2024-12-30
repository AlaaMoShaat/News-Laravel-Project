<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Setting;
use App\Utils\ImageManeger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingRequest;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings');
    }
    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function update(SettingRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $current_setting = Setting::findOrFail($request->setting_id);
            $setting = $current_setting->update($request->except(['_token',  'setting_id', 'logo', 'favicon']));

            if ($request->hasFile('logo')) {
                $this->updateLogo($request, $current_setting);
            }
            if ($request->hasFile('favicon')) {
                $this->updateFavicon($request, $current_setting);
            }

            DB::commit();
            if (!$setting) {
                return redirect()->back()->with('error', 'Try Again latter!');
            }
            return redirect()->back()->with('success', 'Setting Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    private function updateLogo($request, $current_setting)
    {
        ImageManeger::deleteImageLocaly($current_setting->logo);
        $file = ImageManeger::generateImageName($request->logo);
        $logo_path = ImageManeger::storeImageLocaly($request->logo, 'setting', $file);
        $current_setting->update([
            'logo' => $logo_path,
        ]);
    }
    private function updateFavicon($request, $current_setting)
    {
        ImageManeger::deleteImageLocaly($current_setting->favicon);
        $file = ImageManeger::generateImageName($request->favicon);
        $favicon_path = ImageManeger::storeImageLocaly($request->favicon, 'setting', $file);
        $current_setting->update([
            'favicon' => $favicon_path,
        ]);
    }
}
