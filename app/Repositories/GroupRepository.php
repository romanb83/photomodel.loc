<?php

namespace App\Repositories;

use App\Models\Group as Model;
use Illuminate\Database\Eloquent\Collection;

class GroupRepository extends CoreRepository
{
    //  Создаёт экземпляр модели
    //
    protected function getModelClass()
    {
        return Model::class;
    }

    /////////////////////////////////////////////////////////////////////////////
    //  Метод выводит всех пользователей из группы $group с пагинацией $perPage
    //  по умолчанию равной 10
    //
    public function showAllUsersInGroupWithPaginate($group, $perPage = 10)
    {
        $columns = ['id', 'first_name', 'last_name', 'age', 'email'];

        $result = $this
                ->startCondition()
                ->with(['user'])
                ->where('alias', $group)
                ->first()
                ->user()
                ->select($columns)
                ->paginate($perPage);

        return $result;
    }
    /////////////////////////////////////////////////////////////////////////////

    public function showGroup($group)
    {
        $result = $this
                ->startCondition()
                ->where('alias', $group)
                ->select(['id', 'group_name', 'alias'])
                ->first();

        return $result;
    }

    //////////////////////////////////////////////////////////////////////////////

    public function getForSelectList()
    {
        $result = $this
                ->startCondition()
                ->get();

        return $result;
    }

}
?>
