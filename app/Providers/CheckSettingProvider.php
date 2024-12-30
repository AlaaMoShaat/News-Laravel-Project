<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $get_setting = Setting::firstOr(function () {
                $date = fake()->date('Y-m-d h:m:s');
                return Setting::create([
                    'site_name' => 'News_2024',
                    'email' => 'news2024@gmail.com',
                    'favicon' => 'default',
                    'logo' => '/assets/frontend/img/logo.png',
                    'facebook' => 'https://www.facebook.com/',
                    'instagram' => 'https://www.instagram.com/',
                    'twitter' => 'https://www.x.com/',
                    'youtube' => 'https://www.youtube.com/',
                    'street' => 'Elsharawi',
                    'city' => 'Alex',
                    'country' => 'Egypt',
                    'phone' => '+201021965455',
                    'small_desc' => 'Setting small_desc',
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            });

            $get_setting->whatsapp = 'https://wa.me/' . $get_setting->phone;

            view()->share([
                'get_setting' => $get_setting,
            ]);
        }
    }
}
