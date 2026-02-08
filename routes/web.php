<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaperController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dash', function () {
    return view('dash');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/auth/login' , 'render_login_page')->name('login_page');
    Route::get('/auth/signup' , 'render_signup_page')->name('signup_page');

});

Route::controller(PaperController::class)->group(function(){
    Route::get("/paeprs" , 'render_browse_papers')->name('browse_papers');
    Route::get("/papers/{id}/" , 'render_detail_page')->name('detail_page');
});
