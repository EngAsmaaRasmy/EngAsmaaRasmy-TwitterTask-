<?php

namespace App\Repositories;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageRepository
{
    public function upload($file)
    {
        $path = $file->store('images', 'public');
        $image = Image::create([
            'path' => $path,
            'status' => 'pending',
        ]);

        return $image;
    }

    public function getAll()
    {
        return Image::all();
    }

    public function approve($id)
    {
        $image = Image::findOrFail($id);
        $image->status = 'approved';
        $image->save();

        return $image;
    }

    public function reject($id)
    {
        $image = Image::findOrFail($id);
        $image->status = 'rejected';
        $image->save();

        return $image;
    }
}
