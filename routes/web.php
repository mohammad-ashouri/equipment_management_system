<?php

use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\BuildingController;
use App\Http\Controllers\Catalogs\PermissionController;
use App\Http\Controllers\Catalogs\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HardwareEquipments\CaseController;
use App\Http\Controllers\HardwareEquipments\MonitorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Reports\DatabaseBackupController;
use App\Http\Controllers\UserManager;
use App\Http\Middleware\CheckLoginMiddleware;
use App\Http\Middleware\MenuMiddleware;
use App\Http\Middleware\NTCPMiddleware;
use App\Http\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


//Login Routes
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::middleware(ThrottleRequests::class)->post('/login', [LoginController::class, 'login']);
Route::get('/captcha', [LoginController::class, 'getCaptcha'])->name('captcha');


//Panel Routes
Route::middleware(['auth', MenuMiddleware::class])->middleware(MenuMiddleware::class)->group(function () {
    Route::get('/dateandtime', [DashboardController::class, 'jalaliDateAndTime']);
    Route::get('/date', [DashboardController::class, 'jalaliDate']);
    Route::get('/Profile', [DashboardController::class, 'Profile'])->name('Profile');
    Route::post('/ChangePasswordInc', [DashboardController::class, 'ChangePasswordInc']);
    Route::post('/ChangeUserImage', [DashboardController::class, 'ChangeUserImage']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(NTCPMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //User Manager
        Route::get('/UserManager', [UserManager::class, 'index'])->name('UserManager');
        Route::get('/GetUserInfo', [UserManager::class, 'getUserInfo'])->name('GetUserInfo');
        Route::Post('/NewUser', [UserManager::class, 'newUser'])->name('NewUser');
        Route::Post('/EditUser', [UserManager::class, 'editUser'])->name('EditUser');
        Route::Post('/ChangeUserActivationStatus', [UserManager::class, 'changeUserActivationStatus'])->name('ChangeUserActivationStatus');
        Route::Post('/ChangeUserNTCP', [UserManager::class, 'ChangeUserNTCP'])->name('ChangeUserNTCP');
        Route::Post('/ResetPassword', [UserManager::class, 'ResetPassword'])->name('ResetPassword');

        //Role Controller
        Route::resource('/Roles', RoleController::class);
        Route::resource('/Permissions', PermissionController::class);

        //Catalogs
        Route::resource('/Buildings', BuildingController::class);
        Route::resource('/Brands', BrandController::class);

        //Hardware Equipments
        Route::resource('/Monitors', MonitorController::class);
        Route::resource('/Cases', CaseController::class);

        //Reports
        Route::prefix('BackupDatabase')->group(function () {
            Route::get('/', [DatabaseBackupController::class, 'index']);
            Route::post('/', [DatabaseBackupController::class, 'createBackup']);
        });
    });
});

