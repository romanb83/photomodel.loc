<?php

namespace App\Repositories;

use App\Models\Genre as Model;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /// Вытаскивет все поля из таблицы "Жанры"(genres) и возвращает коллекцию объектов
    ///
    public function showAllGenres()
    {
        $result = $this
                ->startCondition()
                ->get();

        return $result;
    }

    public function selectGenresFromRequest($request)
    {
        $req = $request->only(['portrait','beauty','fashion','boudoir','nude','nu-art','met-art',
                        'advertising','landscape','street','wedding','family','children','reportage',
                        'wild','bw','macro','travel','interior','night','astro','architecture','still',
                        'shows']);
        dd($req);
        // $genre = 
    }

}


?>