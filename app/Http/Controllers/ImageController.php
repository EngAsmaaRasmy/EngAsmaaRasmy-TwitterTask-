<?php

// app/Http/Controllers/ImageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImageService;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image = $this->imageService->upload($request->file('image'));

        return response()->json(['status' => 'success', 'image' => $image]);
    }

    public function getImages()
    {
        $images = $this->imageService->getAll();

        return response()->json(['images' => $images]);
    }

    public function approveImage($id)
    {
        $image = $this->imageService->approve($id);

        return response()->json(['status' => 'success', 'image' => $image]);
    }

    public function rejectImage($id)
    {
        $image = $this->imageService->reject($id);

        return response()->json(['status' => 'success', 'image' => $image]);
    }
}
