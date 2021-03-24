<?php

namespace App\Http\Controllers\Photo;

use App\Http\Requests\AvatarRequest;
use App\Http\Requests\DirectoryRequest;
use App\Http\Requests\PhotoRequest;
use App\Models\Photo;
use App\Services\PhotoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class PhotoController
 * @package App\Http\Controllers\Photo
 */
class PhotoController extends BaseController
{
    private $photoService;
    private $photo;

    public function __construct(PhotoService $photoService, Photo $photo)
    {
        parent::__construct();
        $this->photoService = $photoService;
        $this->photo = $photo;
    }

    public function showPhotosPage(Photo $photo)
    {
        $allAlbum = $this->photo->getAllAlbum();

        return view('photo.profile.photos', compact('allAlbum', 'photo'));
    }

    public function uploadPage()
    {
        return view('photo.profile.upload');
    }

    public function avatar(AvatarRequest $request)
    {
        $this->photoService->saveAvatar($request['avatar']);

        return redirect()->route('edit.profile');
    }

    public function save(PhotoRequest $request)
    {
        $quantity = $this->photoService->quantityUserPhotos();
        $countPhotoDb = $this->photo->getAllUserPhotos()->count();
        $countPhotoRequest = count($request['photos']);

        if (($countPhotoDb + $countPhotoRequest) <= $quantity) {
            $this->photoService->savePhotos($request['photos']);

            return redirect()->route('show.photos');
        } else {
            return redirect()->back()->withErrors(['msg' => 'Вы превысили лимит фотографий на ' . (($countPhotoDb + $countPhotoRequest) - $quantity)]);
        }
    }

    public function saveToAlbum(PhotoRequest $request, $name)
    {
        $quantity = $this->photoService->quantityUserPhotos();
        $countPhotoDb = $this->photo->getAllUserPhotos()->count();
        $countPhotoRequest = count($request['photos']);

        if (($countPhotoDb + $countPhotoRequest) <= $quantity) {
            $this->photoService->savePhotos($request['photos'], $name);

            return redirect()->route('photos.in.album', $name);
        } else {
            return redirect()->back()->withErrors(['msg' => 'Вы превысили лимит фотографий на ' . (($countPhotoDb + $countPhotoRequest) - $quantity)]);
        }
    }

    public function delete($id)
    {
        $photo = $this->photo->getPhotoById($id);
        $this->photoService->deletePhoto($photo->path);
        $this->photoService->deletePhoto($photo->thumb);
        $this->photo->destroy($id);

        return redirect()->route('edit.profile');
    }


    /**
     * @param DirectoryRequest $request
     * @return RedirectResponse
     */
    public function makeAlbum(DirectoryRequest $request)
    {
        if ($this->photoService->albumCount() === $this->photoService->quantityUserAlbum()) {
            return redirect()->back()->withErrors(['error' => 'Вы не можете создать больше ' . $this->photoService->quantityUserAlbum() . ' альбомов']);
        }

        $album = Str::slug($request['nameDir'], '-');

        if ($this->photoService->existNameAlbum($album)) {
            return redirect()->back()->with(['msg' => 'Такой альбом уже существует']);
        }

        $this->photoService->makePhotoDirectory($album);
        $this->photoService->makeThumbDirectory($album);

        Photo::create([
            'album' => $album,
            'name' => $request['nameDir'],
            'path' => 'default/folder.png',               //  ????????????????????????????
            'thumb' => 'folder',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('show.photos');
    }

    /**
     * @param $name
     * @return RedirectResponse
     */
    public function deleteAlbum($name)
    {
        $this->photoService->deletePhotoDirectory($name);
        $this->photoService->deleteThumbDirectory($name);

        Photo::where('album', $name)->delete();

        return redirect()->route('edit.profile');
    }

    public function photosInAlbum($name)
    {
        $photosInAlbum = $this->photo->getAllUserPhotosFromAlbum($name);

        return view('photo.profile.includes._album', compact('photosInAlbum', 'name'));
    }
}


//        try {
//            if ($this->photoService->existNameAlbum($request['nameDir'])) {
//                throw new \DomainException('Такой альбом уже существует');
//            }
//        } catch (\DomainException $exception) {
//            return back()->withErrors($exception->getMessage());
//        }
