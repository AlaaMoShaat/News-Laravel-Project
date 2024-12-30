<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Utils\ImageManeger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts()->active()->with('images')->latest()->get();
        return view('frontend.dashboard.profile', compact('posts'));
    }

    public function storePost(PostRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $this->commentAble($request);
            $request->merge(['user_id' => auth()->user()->id]);
            $post = Post::create($request->except(['_token', 'images']));
            // $post = auth()->user()->posts()->create($request->except(['_token', 'images'])); dont need merge user_id

            ImageManeger::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors', $e->getMessage()]);
        }

        Session::flash('success', 'Post Created Successfuly');
        return redirect()->back();
    }

    public function deletePost(Request $request)
    {
        $post = Post::where('slug', $request->slug)->first();
        if (!$post) {
            abort(404);
        }

        ImageManeger::deleteImages($post);

        $post->delete();
        return redirect()->route('frontend.dashboard.profile')->with('success', 'Post Deleted Successfully');
    }

    public function editPost($slug)
    {
        $post = Post::with(['images'])->whereSlug($slug)->first();
        if (!$post) {
            abort(404);
        }
        return view('frontend.dashboard.edit-post', compact('post'));
    }

    public function updatePost(PostRequest $request)
    {
        $request->validated();

        try {
            DB::beginTransaction();
            $post = Post::findOrFail($request->post_id);
            $this->commentAble($request);
            $post->update($request->except(['images', '_token', 'post_id', 'skip_images_validation']));

            if ($request->hasFile('images')) {
                ImageManeger::deleteImages($post);
                ImageManeger::uploadImages($request, $post);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errros' => $e->getMessage()]);
        }

        Session::flash('success', 'Post Updated Successfuly!');
        return redirect()->route('frontend.dashboard.profile');
    }

    public function deletePostImage(Request $request, $image_id)
    {
        $image = Image::find($request->key);
        if (!$image) {
            return response()->json([
                'status' => '201',
                'msg' => 'Image Not Found',
            ]);
        }

        ImageManeger::deleteImageLocaly($image->path);
        $image->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'image deleted successfully',
        ]);
    }

    public function getComments($id)
    {
        $comments = Comment::with('user')->where('post_id', $id)->active()->get();
        if (!$comments) {
            return response()->json([
                'data' => null,
                'msg' => 'No Comments'
            ]);
        }
        return response()->json([
            'data' => $comments,
            'msg' => 'Have Comments'
        ]);
    }

    private function commentAble($request)
    {
        return $request->comment_able == "on" ? $request->merge(['comment_able' => 1])
            : $request->merge(['comment_able' => 0]);
    }
}