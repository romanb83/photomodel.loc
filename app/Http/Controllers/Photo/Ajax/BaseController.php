<?php

////////////////////////////////////////////////////////////////////////////////////
//   Базовый общий абстрактный контроллер(класс) для контроллеров Ajax!!!   //
////////////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers\Photo\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
    public function __construct()
    {
        
    }
}