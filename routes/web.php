<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\AuthController;

Route::group(
    ['middleware' => 'guest:user'],
    function () {
        Route::get('/', function(){
            return view('site.index');
        })->name('index');
    });

Route::group(
    ['middleware' => 'guest:user'],
    function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'postLogin'])->name('post.login');
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'postRegister'])->name('post.register');
    }
);