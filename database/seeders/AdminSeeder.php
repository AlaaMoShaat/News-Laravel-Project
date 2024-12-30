<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'admain',
            'email' => 'admin@admin.com',
            'username' => 'admin_1',
            'password' => Hash::make('123123123'),
            'role_id' => 1,
        ]);
    }
}
