<?php

namespace App\Http\Controllers\Photo;

use App\Http\Requests\SaveProfileRequest;
use App\Models\Genre;
use App\Models\Photo;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\GenreRepository;
use App\Services\FormService;
use App\Services\PhotoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends BaseController
{
    private $userRepository;
    private $genreRepository;
    private $photoService;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->genreRepository = app(GenreRepository::class);
        $this->photoService = app(PhotoService::class);
    }

    /**
     * @param FormService $formService
     * @param Photo $photo
     * @param User $user
     * @return Factory|View
     */
    public function showProfile(FormService $formService, Photo $photo)
    {
//        $user = Auth::user();
//        dd($user->isUser());
        $itemShowUser = $this->userRepository->showUser(Auth::id());
        $itemExp = $formService->getExperience();
        $itemGenres = $this->userRepository->showGenres();
//        dd($itemGenres);

        return view('photo.profile.profile', compact(
            'itemExp',
            'itemShowUser',
            'itemGenres',
            'photo'
        ));
    }

    /**
     * @param SaveProfileRequest $request
     * @return RedirectResponse
     */
    public function saveProfile(SaveProfileRequest $request)
    {
        $user = Auth::user();

        $arr = array_keys($this->genreRepository->getGenresFromRequest($request));
        $user->genres()->detach();
        if (!empty($arr)) {
            $user->genres()->attach($this->getUserGenresId($arr));
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->profile_flag = TRUE;
        $user->save();

        $userAttr = $user->userAttribute()->first();
//        dd($userAttr);
//        $userAttr = update($request->only(['phone','eye_color','hair_color','weight','height','chest','waist','hip',
//            'clothing_size','foot_size','about','exp','tfp','commerce']));
        $userAttr->phone = $request->phone;
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
        if ($user) {
            return redirect()->route('show.profile');
        } else {
            return back()->withInput();
        }
    }

    /**
     * @param FormService $formService
     * @param GenreRepository $genreRepository
     * @param Photo $photo
     * @return Factory|View
     */

    public function editProfile(FormService $formService, GenreRepository $genreRepository, Photo $photo)
    {
        $itemShowUser = $this->userRepository->showUser(Auth::id());
        $arrayGenres = $this->userRepository->getArrayGenres();
        $userGenres = $this->selectedUserGenres();

        return view('photo.profile.edit_profile', compact(
            'formService',
            'itemShowUser',
            'genreRepository',
            'arrayGenres',
            'userGenres',
            'photo'
        ));
    }

    public function showSettings()
    {
        return \view('photo.profile.settings');
    }

    /**
     * Возвращает массив жанров для вывода на странице редактирования профайла (edit_profile), на основе
     * выбранной группы (slug в таблице group)
     *
     * @return array
     */
    public function selectedUserGenres()
    {
        $userGenresArray = $this->userGenresArray();
        foreach ($this->genreRepository->getAllGenres() as $genre) {
            if (!in_array($genre->genre_en, $userGenresArray)) {
                unset($genre);
            } else {
                $arrayGenre[] = $genre;
            }
        }
        /** @var array $arrayGenre */
        return $arrayGenre;
    }


    /**
     * Возвращает массив жанров, из констант, доступных для пользователя на основе выбранной группы
     * (slug в таблице group)
     *
     * @return array
     */
    public function userGenresArray()
    {
        $select = $this->userRepository->userGroupSlug();

        switch ($select) {
            case 'photografer':
                return Genre::PHOTOGRAFER_GENRES;
            case 'model':
                return Genre::MODEL_GENRES;
            case 'makeup':
                return Genre::MAKEUP_GENRES;
            case 'stylist':
                return Genre::STYLIST_GENRES;
        }
    }

    /**
     * Возвращает массив Id-шников жанров, выбранных пользователем для сохранения в таблице БД
     * со связью "многие ко многим". Таблица user_genres
     *
     * @param $arr
     * @return array
     */

    public function getUserGenresId($arr)
    {
        $genres = $this->genreRepository->getAllGenres();
        foreach ($genres as $item) {
            if (in_array($item->genre_en, $arr)) {
                $result[] = $item->id;
            }
        }
        /** @var array $result */
        return $result;
    }


}
