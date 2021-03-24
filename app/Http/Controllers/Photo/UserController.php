<?php

namespace App\Http\Controllers\Photo;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\CityRepository;

class UserController extends BaseController
{
    private $groupRepository;
    private $userRepository;
    private $cityRepository;

    public function __construct()
    {
        parent::__construct();
        $this->groupRepository = app(GroupRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->cityRepository = app(CityRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group)
    {
        $itemsCollection = $this->groupRepository->showAllUsersInGroupWithPaginate($group, 5);
//        dd($itemsCollection);
        return view('photo.all_user', compact('itemsCollection','group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemsSelectList = $this->groupRepository->getForSelectList();
        $itemsCitySelectList = $this->cityRepository->getAllCities();
        return view('photo.create', compact('itemsSelectList', 'itemsCitySelectList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $item = (new User())->create($data);
        if ($item) {
            return redirect()->route('home');
        }
        else {
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($group, $id)
    {
        $itemUser = $this->userRepository->showUser($id);
        //dd(__METHOD__, $group, $itemsUser);
        return view('photo.user', compact('itemUser', 'group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($group, $id)
    {
        $itemUser = $this->userRepository->showUser($id);
        $itemsGroup = $this->groupRepository->getForSelectList();
        $itemCities = $this->cityRepository->getAllCities();
        //dd($itemUser);
        return view('photo.edit_user', compact('itemUser', 'itemsGroup', 'group', 'itemCities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group, $id)
    {
        $data = $request->all();
        $item = $this->userRepository->showUser($id);
        $result = $item->update($data);
        if ($result) {
            return redirect()
                    ->route('group.edit', [$group, $id]);
        } else {
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($group, $id)
    {
        $result = User::destroy($id);
        if ($result) {
            return redirect()->route('home');
        } else {
            return back();
        }

    }
}
