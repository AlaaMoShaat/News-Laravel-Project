<?php

namespace App\Models;

use App\Models\Post;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use HasSlug;
    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    public function status()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
}