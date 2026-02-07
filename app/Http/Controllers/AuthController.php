<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function render_login_page(){
        return view('auth.login');
    }

     public function render_signup_page(){
        return view('auth.signup');
    }

}
