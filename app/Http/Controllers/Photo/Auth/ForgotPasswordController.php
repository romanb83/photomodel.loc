<?php

namespace App\Http\Controllers\Photo\Auth;

use Illuminate\Http\Request;

class ForgotPasswordController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function forgot()
    {
        dd('forgot');
    }
}
