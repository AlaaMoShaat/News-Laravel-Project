<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getPosts($slug)
    {
        $category_slug = Category::active()->whereSlug($slug)->first();
        $posts = $category_slug->posts()->paginate(9);
        return view('frontend.category-posts', compact('posts', 'category_slug'));
    }
}
