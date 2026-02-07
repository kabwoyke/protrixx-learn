<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/auth/login' , 'render_login_page')->name('login_page');
    Route::get('/auth/signup' , 'render_signup_page')->name('signup_page');

});
