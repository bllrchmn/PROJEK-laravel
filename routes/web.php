<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/student', function (){
//     return view ('student');
// });

// Route::get('/user', [UserController::class, 'index' ]);

Route::get('/student', [StudentController::class, 'index' ]);
