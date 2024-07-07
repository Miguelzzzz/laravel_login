<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;

// Rota publica
// POST - http://127.0.0.1:8000/api/
// {"email": "miguelmarcondes@gmail.com","password": "123456"}
Route::post('/', [LoginController::class,'login'])->name('login');

// Rora restrita
Route::group(['middleware' => ['auth:sanctum']], function(){
    // GET - http://127.0.0.1:8000/api/users?page=1
    Route::get('/users', [UserController::class, 'index']);

    // POST - http://127.0.0.1:8000/api/logout/1
    Route::post('/logout/{user}', [LoginController::class, 'logout']);
});