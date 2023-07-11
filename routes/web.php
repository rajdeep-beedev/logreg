<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// loding index 
Route::get('/',[RegisterController::class, 'index']);

// user registration route
Route::post('/user-register',[RegisterController::class, 'register']);
// login route
Route::post('/login',[RegisterController::class, 'login']);
// email verify route
Route::get('/verify-mail/{email}',[RegisterController::class, 'mail_verify']);

// checking middleware for access
Route::group(['middleware'=>['web','checklogin']],function(){

Route::get('/home',[RegisterController::class, 'home'])->name('home');
Route::get('/logout',[RegisterController::class, 'logout'])->name('logout');
Route::get('/edit-profile/{id}',[RegisterController::class, 'profile'])->name('profile');
Route::post('/update-profile',[RegisterController::class, 'update_profile']);

});