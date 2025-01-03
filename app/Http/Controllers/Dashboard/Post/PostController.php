<?php

namespace App\Http\Controllers\Dashboard\Post;

use App\Models\Post;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\Utils\ImageManger;
use App\Utils\ImageManeger;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:index_posts')->only('index');
        $this->middleware('can:create_posts')->only('create');
        $this->middleware('can:store_posts')->only('store');
        $this->middleware('can:update_posts')->only('update');
        $this->middleware('can:edit_posts')->only('edit');
        $this->middleware('can:destroy_posts')->only('destroy');
        $this->middleware('can:changeStatus_posts')->only('changeStatus');
    }
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;

        $posts = Post::when(request()->keyword, function ($query) {
            $query->where('title', 'LIKE', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });

        $posts = $posts->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $post = Auth::guard('admin')->user()->posts()->create($request->except(['_token', 'images']));

            ImageManeger::uploadImages($request, $post);

            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['erorrs', $e->getMessage()]);
        }

        Session::flash('success', 'Post Created Successfuly!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $request->validated();

        try {
            DB::beginTransaction();
            $post = Post::findOrFail($id);
            $post->update($request->except(['images', '_token', 'skip_images_validation']));

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
        return redirect()->route('dashboard.posts.index');
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
    public function changeStatus($id)
    {
        $post = Post::findOrFail($id);
        if ($post->status == 1) {
            $post->update([
                'status' => 0,
            ]);
            Session::flash('success', 'Post Blocked Suuccessfully!');
        } else {
            $post->update([
                'status' => 1,
            ]);
            Session::flash('success', 'Post Active Suuccessfully!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        ImageManeger::deleteImages($post);
        $post->delete();

        Session::flash('success', 'Post Deleted Suuccessfully!');
        return redirect()->back();
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment Deleted Successfuly']);
    }

    public function changeCommentStatus($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->status == 1) {
            $comment->update([
                'status' => 0,
            ]);
            return response()->json(['message' => 'Comment Blocked Suuccessfully!', 'newStatus' => $comment->status]);
        } else {
            $comment->update([
                'status' => 1,
            ]);
            return response()->json(['message' => 'Comment Active Suuccessfully!', 'newStatus' => $comment->status]);
        }
        return redirect()->back();
    }
}
