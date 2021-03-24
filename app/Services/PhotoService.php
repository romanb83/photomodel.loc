<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PhotoService extends CoreService
{
    private $photo;

    public function __construct(Photo $photo)
    {
        parent::__construct();
        $this->photo = $photo;
    }

    public function resizeToBigSide($user_photo, $side)
    {
        $image = Image::make($user_photo);
        $image->getCore()->stripImage();
        $width = $image->width();
        $height = $image->height();
        if ($width >= $side + 1) {
            $image->resize($side, null, function ($img) {
                $img->aspectRatio();
            });
        } elseif ($height >= $side + 1) {
            $image->resize(null, $side, function ($img) {
                $img->aspectRatio();
            });
        }
//        $image->sharpen(10);
        $image->encode('jpg');

        return $image;
    }

    public function generateFilename()
    {
        $filename = Str::random(16);
        $full_name = $this->photo->photoPath() . $filename;
        foreach ($this->photo->getAllUserPhotos() as $file) {
            if ($file->path === $full_name) {
                return $filename . Str::random(6);
            }
        }

        return $filename;
    }

    /**
     *  Проверяет существование имени альбома в БД.
     * @param $name
     * @return bool
     */
    public function existNameAlbum($name): bool
    {
        foreach ($this->photo->getAllAlbum() as $item) {
            $collection = collect($item);
            if ($collection->contains($name)) {
                return true;
            }
        }
        return false;
    }

    /**
     *  Возвращает количество фотографий доступных пользователю согласно тарифа
     * @return int
     */
    public function quantityUserPhotos()
    {
        /**@var User $user**/
        $user = Auth::user();

        if ($user->isUser()) {
            return Photo::BASE_QUANTITY_PHOTO;
        }
        if ($user->isPremium()) {
            return Photo::PREMIUM_QUANTITY_PHOTO;
        }
        if ($user->isVip()) {
            return Photo::VIP_QUANTITY_PHOTO;
        }
    }

    /**
     *  Возвращает количество альбомов доступных пользователю согласно тарифа
     *  @return int
     */

    public function quantityUserAlbum()
    {
        /**@var User $user**/
        $user = Auth::user();

        if ($user->isPremium()) {
            return Photo::PREMIUM_ALBUM;
        }
        if ($user->isVip()) {
            return Photo::VIP_ALBUM;
        }
    }

    /**
     * @param $request
     * @param null $album
     */
    public function savePhotos($request, $album = NULL)
    {
        foreach ($request as $itemPhoto) {
            $filename = $this->generateFilename();
            $filenameThumb = 'thumb_' . $filename;
            $image = $this->resizeToBigSide($itemPhoto, Photo::PHOTO_BIG_SIDE);
            $thumb = $this->resizeToBigSide($itemPhoto, Photo::THUMB_BIG_SIDE);
            $path = $this->photo->photoPath($album) . $filename . Photo::EXT_JPG;
            $pathThumb = $this->photo->thumbPath($album) . $filenameThumb . Photo::EXT_JPG;
            $this->savePhoto($path, $image, 'public');
            $this->savePhoto($pathThumb, $thumb, 'public');

            Photo::create([
                'path' => $path,
                'thumb' => $pathThumb,
                'album' => $album,
                'user_id' => Auth::id(),
            ]);
        }
    }

    /**
     * @param $request
     */
    public function saveAvatar($request)
    {
        $avatar = $this->resizeToBigSide($request, Photo::AVATAR_BIG_SIDE);
        $thumb = $this->resizeToBigSide($request, Photo::THUMB_AVATAR_BIG_SIDE);
        $path = $this->photo->photoPath() . 'avatar.jpg';
        $pathThumb = $this->photo->thumbPath() . 'thumb_avatar.jpg';
        $this->savePhoto($path, $avatar, 'public');
        $this->savePhoto($pathThumb, $thumb, 'public');

        $photo = new Photo();
        $photo->where('album', 'avatar')->update([
            'path' => $path,
            'thumb' => $pathThumb,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * @return int
     */
    public function albumCount()
    {
        $allAlbum = $this->photo->getAllAlbum();
        if ($allAlbum->isNotEmpty()) {
            return $allAlbum->count();
        }

        return 0;
    }

    public function savePhoto($path, $image, $options)
    {
        Storage::disk(env('STORAGE_DISK'))->put($path, $image, $options);
    }

    public function deletePhoto($path)
    {
        Storage::disk(env('STORAGE_DISK'))->delete($path);
    }

    public function makePhotoDirectory($nameDir)
    {
        Storage::disk(env('STORAGE_DISK'))->makeDirectory($this->photo->photoPath() . $nameDir);
    }

    public function makeThumbDirectory($nameDir)
    {
        Storage::disk(env('STORAGE_DISK'))->makeDirectory($this->photo->thumbPath() . $nameDir);
    }

    public function deletePhotoDirectory($nameDir)
    {
        Storage::disk(env('STORAGE_DISK'))->deleteDirectory($this->photo->photoPath() . $nameDir);
    }

    public function deleteThumbDirectory($nameDir)
    {
        Storage::disk(env('STORAGE_DISK'))->deleteDirectory($this->photo->thumbPath() . $nameDir);
    }

}
