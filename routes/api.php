<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('tasks',[TaskController::class,'index'])->name('tasks.index');
    Route::get('tasks/{id}',[TaskController::class,'show'])->name('tasks.show');
    Route::put('tasks/update/{id}',[TaskController::class,'update'])->name('tasks.update');
    Route::delete('tasks/destroy/{id}',[TaskController::class,'destroy'])->name('tasks.destroy');
    Route::post('tasks',[TaskController::class,'store'])->name('tasks.store');
    Route::post('logout',[AuthController::class,'logout'])->name('auth.logout');

    Route::group(['prefix'=> 'V1','namespace' => 'App\Http\Controllers\Api\V1'],function(){
        Route::get('tasks/affiche/{id}',[TaskController::class,'affiche'])->name('tasks.affiche');
        // Route::apiResource('tasks',TaskController::class);
    });
    
});

Route::post('register',[AuthController::class,'register'])->name('auth.register');
Route::post('login',[AuthController::class,'login'])->name('auth.login');

