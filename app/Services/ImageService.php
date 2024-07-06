<?php
namespace App\Services;

use App\Repositories\ImageRepository;

class ImageService
{
    protected $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function upload($file)
    {
        return $this->imageRepository->upload($file);
    }

    public function getAll()
    {
        return $this->imageRepository->getAll();
    }

    public function approve($id)
    {
        return $this->imageRepository->approve($id);
    }

    public function reject($id)
    {
        return $this->imageRepository->reject($id);
    }
}
