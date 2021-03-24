<?php

namespace App\Repositories;

use App\Models\Photo;
use App\Services\FileService;
use Storage;

class PhotoRepository extends CoreRepository
{
    private $fileService;

    public function __construct()
    {
        parent::__construct();
        $this->fileService = new FileService();
    }

    public function setPhotoId($id)
    {
        Photo::create([
            'user_id' => $id,
            'path' => $this->fileService->defaultCloudPath().'default\avatar.png',
            'album' => 'avatar',
        ]);
        Storage::disk(env('STORAGE_DISK'))->makeDirectory($this->fileService->defaultCloudPath().$id);
        Storage::disk(env('STORAGE_DISK'))->makeDirectory($this->fileService->defaultCloudPath().$id . '\thumbs');
    }
}
