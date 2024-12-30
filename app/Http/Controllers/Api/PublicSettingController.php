<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\RelatedNewsSite;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;

class PublicSettingController extends Controller
{
    public function getSettings()
    {
        $setting = Setting::first();

        if (!$setting) {
            return apiResponse(404, 'Setting is empty');
        }

        $data = [
            'setting' => new SettingResource($setting),
            'relatd_site' => $this->relatedSites()

        ];
        return apiResponse(200, 'This is site Setting', $data);
    }
    public function relatedSites()
    {
        $relatd_site = RelatedNewsSite::select('name', 'url')->get();
        if (!$relatd_site) {
            return apiResponse(404, 'There are not related sites');
        }
        return $relatd_site;
    }
}