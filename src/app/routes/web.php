<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::get('/resendotp', 'resendOTP')->name('resendOTP');
    Route::get('/generateotp', 'generateOTP')->name('generateOTP');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/twofactor', 'twofactor')->name('twofactor');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user-profile', 'userProfile')->name('user.profile');
});

Route::get('user-data', function () {
    $model = User::query();

    return DataTables::of($model)->toJson();
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UsersController::class)
    ->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'update' => 'users.update',
        'show' => 'users.show',
        'destroy' => 'users.destroy',
    ]);

    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
