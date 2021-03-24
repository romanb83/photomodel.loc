<?php

namespace App\Repositories;

use App\Models\Region as Model;
use Illuminate\Database\Eloquent\Collection;

class RegionRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /////////////////////////////////////////////////////////////
    //  Берёт из базы все регионы для выпадающего списка
    public function getAllRegions()
    {
        $result = $this
                ->startCondition()
                ->get();

        return $result;
    }

    public function getSelectedRegions($id)
    {
        $result = $this
                ->startCondition()
                ->where('country_id', $id)
                ->get();
        // dd($result);
        return $result;
    }
}


?>