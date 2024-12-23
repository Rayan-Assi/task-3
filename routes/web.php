<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/* Route::get('/',[PostController::class,"index"])->name("posts.index");

Route::get('/add',[PostController::class,"create"])->name("posts.create");
Route::post("/",[PostController::class,"store"])->name("posts.store");

Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');

Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');

Route::delete('/posts/{id}',[PostController::class,"destroy"])->name("posts.destroy");

Route::get('/show/{id}',[PostController::class,"show"])->name("posts.show");
 */

Route::middleware('guest')->group(
    function () {
        Route::get('/', [AuthController::class, "ShowLoginForm"])->name("login");
        Route::post('/', [AuthController::class, "login"]);
    }
);


Route::middleware('auth')->group(
    function () {
        Route::resource('posts', PostController::class);

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/user', [UserController::class, "MakeLoginForm"])->name("login2");
        Route::post('/user', [UserController::class, "loginUser"]);


        Route::middleware('can:manageUser')->group(
            function () {
                Route::get('/users', [UserController::class, 'index'])->name("users.index");
                Route::get('/add_user', [UserController::class, "create"])->name("user.create");
                Route::post("/add_user", [UserController::class, "store"])->name("user.store");
                Route::get('/edit_user/{id}', [UserController::class, 'edit'])->name('user.edit');
                Route::put('/update_user/{id}', [UserController::class, 'update'])->name('user.update');
                Route::delete('/users/{id}', [UserController::class, "destroy"])->name("user.destroy");
            }
        );
    }
);
