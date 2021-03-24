<?php

//////////////////////////////////////////////////////////////
//   Базовый абстрактный контроллер(класс) для админки!!!   //
//////////////////////////////////////////////////////////////

namespace App\Http\Controllers\Photo\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
    public function __construct()
    {
        
    }
}
