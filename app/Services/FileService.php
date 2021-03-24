<?php

namespace App\Services;

use Carbon\Carbon;

class FileService extends CoreService
{
    public $carbon;

    public function __construct()
    {
        parent::__construct();
        $this->carbon = new Carbon();
    }

    public function defaultCloudPath()
    {
        $result = $this->carbon->year.'\\'.$this->carbon->month.'\\';
//        dd($result);
        return $result;
    }
}
