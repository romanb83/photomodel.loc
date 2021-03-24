<?php

namespace App\Http\Controllers\Photo\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CountryRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\CityRepository;

class LocationController extends BaseController
{
    private $countryRepository; 

    public function __construct()
    {
        parent::__construct();
        $this->countryRepository = app(CountryRepository::class);       
    }

    // public function getCountryForSelectList()
    // {
    //     $itemsCountrySelectList = $this->countryRepository->getAllCountry();

    //     return view('photo.admin.create', compact('itemsCountrySelectList'));
    // }
}
