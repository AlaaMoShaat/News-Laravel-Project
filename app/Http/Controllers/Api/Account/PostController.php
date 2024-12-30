<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\Post;
use App\Utils\ImageManger;
use App\Utils\ImageManeger;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PostCollection;
use App\Http\Resources\CommentResource;
use App\Notifications\NewCommentNotify;
use App\Http\Requests\Frontend\CommentRequest;

class PostController extends Controller
{
    public function getUserPosts()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return apiResponse(404, 'User Not Found');
        }
        $posts = $user->posts()->active()->activeCategory()->get();
        if ($posts->count() > 0) {
            return apiResponse('200', 'This is user Posts', new PostCollection($posts));
        }
        return apiResponse(404, 'No Posts To this User');
    }

    public function storeUserPost(PostRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = auth()->user()->posts()->create($request->except(['images']));
            ImageManeger::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');

            return apiResponse(201, 'Post Created Successfully');
        } catch (\Exception $e) {
            Log::error('Error Store User Post : ' . $e->getMessage());
            return apiResponse(400, 'Bad Request');
        }
    }

    public function destroyUserPost($post_id)
    {
        $user = auth()->user();
        $post = $user->posts()->where('id', $post_id)->first();

        if (!$post) {
            return apiResponse(404, 'Post Not Found');
        }
        ImageManeger::deleteImages($post);
        $post->delete();

        return apiResponse(200, 'Post Deleted Successfully!');
    }

    public function getPostComments($post_id)
    {
        $user = auth()->user();
        $post = $user->posts()->where('id', $post_id)->first();
        if (!$post) {
            return apiResponse(404, 'Post Not Found');
        }

        if ($post->comments->count() > 0) {
            return apiResponse(200, 'Comments', CommentResource::collection($post->comments));
        }
        return apiResponse(404, 'Post Comments Less Than One');
    }

    public function updateUserPost(PostRequest $request, $post_id)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            $post = $user->posts()->where('id', $post_id)->first();
            if (!$post) {
                return apiResponse(404, 'Post Not Found');
            }

            $post->update($request->except(['images', '_method']));

            if ($request->hasFile('images')) {
                ImageManeger::deleteImages($post);
                ImageManeger::uploadImages($request, $post);
            }
            DB::commit();
            return apiResponse(200, 'Post Updated Successfully');
        } catch (\Exception $e) {
            Log::error('Error Update User Post', $e->getMessage());
            return apiResponse(400, 'try again latter!');
        }
    }

    public function StoreComment(CommentRequest $request)
    {
        $post = Post::find($request->post_id);
        if (!$post) {
            return apiResponse(404, 'Post Not Found');
        }

        $comment = $post->comments()->create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
        ]);

        if (auth()->user()->id != $post->user_id) {
            $post->user->notify(new NewCommentNotify($comment, $post));
        }

        // $comment->load('user');
        if (!$comment) {
            return apiResponse('400', 'Try Again Latter!');
        }
        return apiResponse(201, 'Comment Created Successfully!!');
    }
}
