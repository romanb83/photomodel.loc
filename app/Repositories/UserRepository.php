<?php

namespace App\Repositories;

//use App\Models\User as Model;
use App\Models\Genre;
use App\Models\Photo;
use App\Models\UserAttribute;
use App\Services\FileService;
use Auth;
use Storage;

class UserRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////
    /////  Возвращает пользователя по id с полями указанными в $columns
    ////////////////////////////////////////////////////////////////////
    public function showUser($id)
    {
        $columns = ['id', 'first_name', 'last_name', 'username', 'email', 'city_id', 'group_id'];

        $result = $this
            ->startCondition()
            ->where('id', $id)
            ->select($columns)
            ->with('city:id,city_ru,city_en')
            ->with('userAttribute:user_id,phone,eye_color,hair_color,height,weight,chest,waist,hip,clothing_size,foot_size,about,experience,is_tfp,is_commerce')
            ->with('group:id,group_name,slug')
            ->first();
        // dd($result);
        return $result;
    }


    ///////////////////////////////////////////////////////////////////////////////////
    /////  Показывает данные нового зарегистрированного пользователя на странице профайла

    public function showUserProfile()
    {
        $columns = ['id', 'nick_name', 'email',];

        $result = $this
            ->startCondition()
            ->where('id', Auth::id())
            ->select($columns)
            ->first();

        return $result;
    }

    //////////////////////////////////////////////////////////////////
    // Устанавливает в поле user_id таблицы user_attribute айдишник нового
    // зарегистрированного пользователя

    public function setUserAttributeId($id)
    {
        $userAttribute = new UserAttribute();
        $result = $userAttribute->create(['user_id' => $id]);

        return $result;
    }

    //////////////////////////////////////////////////////////////////
    // Устанавливает в поле user_id таблицы photos айдишник нового
    // зарегистрированного пользователя
    public function setPhotoId($id)
    {
        $photo = new Photo();
        $result = $photo->create(['user_id' => $id, 'name' => 'avatar', 'weight' => 250, 'height' => 260]);
        Storage::disk('user')->makeDirectory($id);
        Storage::disk('user')->makeDirectory($id . '/thumbs');

        return $result;
    }


    /////////////////////////////////////////////////////////////////////////////////
    /// Сохраняет данные профайла

    public function saveUserProfile($request)
    {
        // dd($request);
        $user = Auth::user();
        if (empty($request->first_name)) {
            $user->first_name = $user->nick_name;
        } else {
            $user->first_name = $request->first_name;
        }

        if (!empty($request->file('uploadFile'))) {
            $avatar = new FileService();
            $avatar->saveAvatar($request->file('uploadFile'), 'avatar.jpg');
            $userPhoto = $user->photos()->first();
            $userPhoto->size = $avatar->getFileSize('avatar.jpg');
            $user->photos()->save($userPhoto);
        }

        $arr = array_keys($this->getSelectGenresFromRequest($request));
        // dd($arr);
        // $this->getGenres($arr);
        $user->genres()->detach();
        $user->genres()->attach($this->getGenres($arr));
            // dd(1);




        $user->last_name = $request->last_name;
        $user->group_id = $request->group_id;
        $user->city_id = $request->city_id;
        $user->profile_flag = TRUE;
        $user->save();

        $userAttr = $user->userAttribute()->first();
        if (empty($userAttr->age)) {
            $userAttr->age = $request->age;
        } else {
            $userAttr->age = $userAttr->age;
        }
        $userAttr->phone = $request->phone;
        $userAttr->gender = $request->gender;
        $userAttr->eye_color = $request->eye_color;
        $userAttr->hair_color = $request->hair_color;
        $userAttr->weight = $request->weight;
        $userAttr->height = $request->height;
        $userAttr->chest = $request->chest;
        $userAttr->waist = $request->waist;
        $userAttr->hip = $request->hip;
        $userAttr->clothing_size = $request->clothing_size;
        $userAttr->foot_size = $request->foot_size;
        $userAttr->about = $request->about;
        $userAttr->experience = $request->exp;
        $userAttr->is_tfp = $request->tfp;
        $userAttr->is_commerce = $request->commerce;
        $user->userAttribute()->save($userAttr);

        return $user;
    }


    /// Вытаскивет все поля из таблицы "Жанры"(genres) у ЗАРЕГИСТРИРОВАННОГО пользователя
    /// и возвращает коллекцию объектов
    ///
    public function showGenres()
    {
        $result = $this
                ->startCondition()
                ->find(Auth::id())
                ->genres()
                ->get();

        // dd($result);

        return $result;
    }

    /// Достаёт из Request только указанные поля для формирования жанров
    ///
    public function getSelectGenresFromRequest($request)
    {
        $req = $request->only(['portrait','beauty','fashion','boudoir','nude','nu-art','met-art',
                        'advertising','landscape','street','wedding','family','children','reportage',
                        'wild','bw','macro','travel','interior','night','astro','architecture','still',
                        'shows']);

        if (empty($req)) {
            $req = ['no' => 1];
        }
                        // dd($req);

        return $req;
    }

    /// Возвращает жанры характерные для конкретного пользователя в виде массива
    ///
    /// @return array
    ///
    public function getGenres($arr)
    {
        $genre = new Genre();
        $itemsGenre = $genre->get();
        foreach ($itemsGenre as $item) {
            if (in_array($item->genre, $arr)) {
                $result[] = $item->id;
            }
        }
        // dd($result);
        return $result;
    }

    /// Вытаскивет из таблицы "Жанры"(genres) все поля "Жанр"(genre) и возвращает их в виде массива
    ///
    public function getArrayGenres()
    {
        $temp = $this
                ->startCondition()
                ->find(Auth::id())
                ->genres()
                ->get();

        foreach ($temp as $item) {
            $result[] = $item->genre;
        }
        if (empty($result)) {
            $result = null;
        }
        return $result;

    }

    // public function setDefaultGenre()
    // {
    //     Auth::user()->genres()->attach([25]);


    //     // return $result;
    // }
}
