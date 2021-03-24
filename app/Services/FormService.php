<?php

namespace App\Services;

use Carbon\Carbon;

class FormService extends CoreService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fullDateFromRequest($request)
    {
        $result = Carbon::createFromDate($request->year, $request->month, $request->day);
        $request->request->add(['age' => $result]);
        $request->request->remove('day');
        $request->request->remove('month');
        $request->request->remove('year');

//         dd($request);
        return $request;
    }

    public function getDay()
    {
        $result = [];
        $i = 0;
        for ($i=1; $i <= 31; $i++) {
            $result[] = $i;
        }

        return $result;

    }

    public function getMonth()
    {
        $result = [ '01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель',
                   '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август',
                   '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь'];

        return $result;
    }

    public function getYear()
    {
        $obj = new Carbon();
        for ($i=$obj->year-70; $i <= $obj->year; $i++) {
            $result[] = $i;
        }

        return $result;
    }

    public function getExperience()
    {
        $result = ['no' => 'Без опыта', 'low' => 'Небольшой',
                   'middle' => 'Средний', 'big' => 'Большой', 'profi' => 'Профессиональный'];

        return $result;
    }
}
