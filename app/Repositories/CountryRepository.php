<?php

namespace App\Repositories;

use App\Models\Country as Model;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /////////////////////////////////////////////////////////////
    //  Берёт из базы все страны для выпадающего списка
    public function getAllCountries()
    {
        $result = $this
                ->startCondition()
                ->get();

        return $result;
    }

}


?>