<?php

namespace App\Http\Controllers\Photo;

use App\Repositories\GroupRepository;
use App\Services\FileService;

class IndexController extends BaseController
{
    private $groupRepository;

    public function __construct()
    {
        parent::__construct();
        $this->groupRepository = app(GroupRepository::class);
    }

    public function index(FileService $fileService)
    {
        $fileService->defaultCloudPath();
        return view('home');

//        $itemsGroup = $this->groupRepository->getForSelectList();
//
//        return view('photo.index', compact('itemsGroup'));
    }
}
