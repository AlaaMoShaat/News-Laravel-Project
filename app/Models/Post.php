<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use HasSlug;
    protected $guarded = [];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'post_id');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeActiveUser($query)
    {
        $query->where(function ($query) {
            $query->whereHas('user', function ($user) {
                $user->whereStatus(1);
            })->orWhere('user_id', null);
        });
    }
    public function scopeActiveCategory($query)
    {
        $query->whereHas('category', function ($category) {
            $category->whereStatus(1);
        });
    }
    public function status()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

    // public function getStatusAttribute() //For All Instants (( Laravel Accessors ))
    // {
    //     return $this->attributes['status'] == 1 ? 'Active' : 'Inactive';
    // }
}