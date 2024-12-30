<?php

namespace App\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ImageManeger
{
    public static function uploadImages($request, $post)
    {
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $file = self::generateImageName($image);
                $path = self::storeImageLocaly($image, 'posts', $file);
                $post->images()->create([
                    'path' => $path,
                ]);
            }
        }
    }

    public static function deleteImages($post)
    {
        if ($post->images->count() > 0) {
            foreach ($post->images as $image) {
                self::deleteImageLocaly($image->path);
                $image->delete();
            }
        }
    }

    public static function uploadImage($request, $user)
    {
        if ($request->hasFile('image')) {
            $image = $request->image;
            self::deleteImageLocaly($user->image);

            $file = self::generateImageName($image);
            $path = self::storeImageLocaly($image, 'users', $file);
            $user->update(['image' => $path]);
        }
    }

    public static function generateImageName($image)
    {
        $file = Str::uuid() . time() . $image->getClientOriginalExtension();
        return $file;
    }

    public static function storeImageLocaly($image, $path, $filename)
    {
        $path = $image->storeAs('uploads/' . $path, $filename, ['disk' => 'uploads']);
        return $path;
    }

    public static function deleteImageLocaly($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
