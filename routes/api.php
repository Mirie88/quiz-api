<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;

//Route::get('/user', function (Request $request) {
 //   return $request->user();
//})->middleware('auth:');

Route::post('/register', [UserController::class, 'store'] );
Route::get('/users', [UserController::class, 'index']);
Route::get('/getUser', [UserController::class, 'getUser']);
Route::post('/login', [UserController::class, 'login'] );
Route::post('/logout', [UserController::class, 'logout'] );

Route::post('/quiz', [QuizController::class, 'store']);
Route::get('/quiz', [QuizController::class, 'index']);
Route::put('/quiz/{quiz}', [QuizController::class, 'update']);
Route::delete('/quiz/{quiz}', [QuizController::class, 'delete']);

Route::middleware('role:admin')->group(function(){
    // Route::apiResource('users', UserController::class);
});

// Route::apiResource('quizzes', QuizController::class);
Route::put('/update/{id}', [UserController::class, 'update']);


Route::get('/question', [QuestionController::class, 'index']);
Route::post('/store', [QuestionController::class, 'store']);
Route::put('/update', [QuestionController::class, 'update']);
Route::get('/show', [QuestionController::class, 'show']);
Route::delete('/delete', [QuestionController::class, 'delete']);