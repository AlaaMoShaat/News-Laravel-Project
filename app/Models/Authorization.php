<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getPermessionsAttribute($permessions) // اكسيسوريز برجع البيرمشنز ك اريه لما اجي استدعيها
    {
        return json_decode($permessions);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }
}
