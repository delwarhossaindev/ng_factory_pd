<?php

namespace App\Helpers;

use App\Models\Image;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ResizeImage;

trait ImageResizeable
{
    public function imageable()
    {
        return $this->morphTo();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function hasImage()
    {
        return (bool) $this->image()->count();
    }

    public function saveImage($request, $width, $height)
    {
        $path = storage_path('app/public/');
        !is_dir($path) && mkdir($path, 0775, true);

        $file     = $request->file('image');
        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());

        if ($this->hasImage()) {
            if (File::exists($path . $this->image->image)) {
                File::delete($path . $this->image->image);
            }
            ResizeImage::make($file)->resize($width, $height)->save($path . $fileName);

            return $this->image()->update([
                'image' => $fileName
            ]);
        }

        ResizeImage::make($file)->resize($width, $height)->save($path . $fileName);

        return $this->image()->create([
            'image' => $fileName
        ]);
    }
}