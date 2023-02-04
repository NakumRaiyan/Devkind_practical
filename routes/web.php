<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CustomeController::class, 'index']);
Route::get('login', [CustomeController::class, 'index'])->name('login-user');
Route::post('custom-login', [CustomeController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomeController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomeController::class, 'customRegistration'])->name('register.custom');

Route::get('dashboard', [CustomeController::class, 'dashboard'])->name('dashboard-user')->middleware('auth');
Route::get('signout', [CustomeController::class, 'signOut'])->name('signout');


Route::get('profile', [CustomeController::class, 'profile'])->name('profile-user')->middleware('auth');
Route::post('profile/{id}', [CustomeController::class, 'customupdate'])->name('profile.update')->middleware('auth');

Route::get('password', [CustomeController::class, 'password'])->name('changepassword-user')->middleware('auth');
Route::post('password/{id}', [CustomeController::class, 'passwordupdate'])->name('password.update')->middleware('auth');

Route::get('viewlogs', [CustomeController::class, 'viewlogs'])->name('viewlogs-user')->middleware('auth');