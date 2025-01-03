<?php

namespace App\Livewire\Dashboard;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Category;

class Statistics extends Component
{
    public function render()
    {
        $active_categories_count = Category::whereStatus(1)->count();
        $active_posts_count = Post::whereStatus(1)->count();
        $comments_count = Comment::count();
        $active_users_count = User::whereStatus(1)->count();

        return view('livewire.dashboard.statistics', [
            'active_categories_count' => $active_categories_count,
            'active_posts_count' => $active_posts_count,
            'comments_count' => $comments_count,
            'active_users_count' => $active_users_count,
        ]);
    }
}
