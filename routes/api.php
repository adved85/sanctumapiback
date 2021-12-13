<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/signin', [AuthController::class, 'signIn' ]);
Route::post('/signup', [AuthController::class, 'signUp' ]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/profile', [AuthController::class, 'profile' ]);
    Route::post('/signout', [AuthController::class, 'signOut' ]);
});

Route::get('/home', [HomeController::class, 'index']);
