<?php

//   Контроллер админки   //

namespace App\Http\Controllers\Photo\Admin;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\CountryRepository;
use App\Repositories\RegionRepository;
use App\Repositories\CityRepository;

class UserController extends BaseController
{
    private $groupRepository;
    private $userRepository;
    private $countryRepository; 
    private $regionRepository;
    private $cityRepository; 

    public function __construct()
    {
        parent::__construct();
        $this->groupRepository = app(GroupRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->countryRepository = app(CountryRepository::class);
        $this->regionRepository = app(RegionRepository::class);
        $this->cityRepository = app(CityRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group)
    {        
        $itemsCollection = $this->groupRepository->showAllUsersInGroupWithPaginate($group, 2);
        $itemsGroup = $this->groupRepository->showGroup($group);
       
        return view('photo.admin.user', compact('itemsCollection', 'itemsGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemsSelectList = $this->groupRepository->getForSelectList();
        //$itemsCountrySelectList = $this->countryRepository->getAllCountries();
        //$itemsRegionSelectList = $this->regionRepository->getAllRegions();
        $itemsCitySelectList = $this->cityRepository->getAllCities();
        //dd($itemsSelectList, $itemsCountrySelectList, $itemsRegionSelectList, $itemsCitySelectList);
        return view('photo.admin.create', compact('itemsSelectList',
                                                //   'itemsCountrySelectList',
                                                //   'itemsRegionSelectList',
                                                  'itemsCitySelectList')
                    );
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
        //dd($data, $item);
        if ($item) {
            // $itemsSelectList = $this->groupRepository->getForSelectList();
            // dd($itemsSelectList);
            return redirect()->route('home');
            
        }
        else {
            return back()->withInput();
        }
        //dd(__METHOD__, $data, $item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($group, $id)
    {
        $itemsUser = $this->userRepository->showUser($id);
        dd(__METHOD__, $group, $itemsUser);
        return $itemsUser;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('photo.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
