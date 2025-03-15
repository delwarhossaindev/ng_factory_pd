<?php

namespace App\Helpers;

use App\Models\Image;
use Illuminate\Support\Facades\File;

trait Imageable
{
    /**
     * Summary of imageable
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Summary of image
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Summary of hasImage
     * @return bool
     */
    public function hasImage()
    {
        return (bool) $this->image()->count();
    }

    /**
     * Summary of saveImage
     * @param mixed $request
     * @return Imageable|\Illuminate\Database\Eloquent\Model|int
     */
    private function saveImage($request)
    {
        if (is_null($request->image) | $request->image === 'Browse file') {
            return $this;
        }

        $path = storage_path('app/public/');
        !is_dir($path) && mkdir($path, 0775, true);

        $file     = $request->file('image');
        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());

        if ($this->hasImage()) {
            if (File::exists($path . $this->image->image)) {
                File::delete($path . $this->image->image);
            }
            $file->move($path, $fileName);
            return $this->image()->update([
                'image'  => $fileName,
            ]);
        }
        $file->move($path, $fileName);
        return $this->image()->create([
            'image'  => $fileName,
        ]);
    }
}
