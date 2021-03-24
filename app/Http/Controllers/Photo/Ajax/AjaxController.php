<?php

namespace App\Http\Controllers\Photo\Ajax;

use Illuminate\Http\Request;
use App\Repositories\RegionRepository;
use App\Repositories\CityRepository;

class AjaxController extends BaseController
{
    private $regionRepository;
    private $cityRepository;

    public function __construct()
    {
        parent::__construct();
        $this->regionRepository = app(RegionRepository::class);
        $this->cityRepository = app(CityRepository::class);

    }

    public function getRegions(Request $request)
    {
//        dd($request);
        $result = $this->regionRepository->getSelectedRegions($request->country);

        return $result;
    }

    public function getCities(Request $request)
    {
        $result = $this->cityRepository->getSelectedCities($request->region);

        return $result;
    }
}
