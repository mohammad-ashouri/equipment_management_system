<?php

use App\Http\Controllers\api\GetEquipmentsController;
use App\Http\Controllers\Catalogs\BookSubjectController;
use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\BuildingController;
use App\Http\Controllers\Catalogs\PermissionController;
use App\Http\Controllers\Catalogs\PublicationController;
use App\Http\Controllers\Catalogs\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\Reports\ConsumablesController;
use App\Http\Controllers\Reports\DatabaseBackupController;
use App\Http\Controllers\Reports\EquipmentController;
use App\Http\Controllers\Reports\HistoryController;
use App\Http\Controllers\UserManager;
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
Route::middleware(['auth', MenuMiddleware::class])->group(function () {
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
        Route::resource('/Publications', PublicationController::class);
        Route::resource('/BookSubjects', BookSubjectController::class);

        //Hardware Equipments
        require_once 'Equipments/HardwareEquipments.php';

        //Network Equipments
        require_once 'Equipments/NetworkEquipments.php';

        //Digital Equipments
        require_once 'Equipments/DigitalEquipments.php';

        //Technical Facilities
        require_once 'Equipments/TechnicalFacilities.php';

        //Gym Facilities
        require_once 'Equipments/GymEquipments.php';

        //Personnels
        Route::resource('/Personnels', PersonnelController::class);
        Route::get('/Personnels/{personnel}/equipments', [EquipmentsController::class, 'equipments'])->name('Personnels.equipments');
        Route::get('/Personnels/{personnel}/equipments/new/{equipmentType}', [EquipmentsController::class, 'newEquipment'])->name('Personnels.equipments.new');
        Route::post('/Personnels/equipments/new', [EquipmentsController::class, 'storeEquipment'])->name('Personnels.equipments.store');
        Route::get('/Personnels/{personnel}/equipments/edit/{equipmentId}', [EquipmentsController::class, 'editEquipment'])->name('Personnels.equipments.edit');
        Route::post('/Personnels/equipments/update', [EquipmentsController::class, 'updateEquipment'])->name('Personnels.equipments.update');
        Route::post('/Personnels/equipments/move', [EquipmentsController::class, 'moveEquipment'])->name('Personnels.equipments.move');
        Route::post('/Personnels/equipments/delete', [EquipmentsController::class, 'deleteEquipment'])->name('Personnels.equipments.delete');

        //Reports
        Route::prefix('BackupDatabase')->group(function () {
            Route::get('/', [DatabaseBackupController::class, 'index']);
            Route::post('/', [DatabaseBackupController::class, 'createBackup']);
        });
        Route::get('/ChangeHistory/{personnel}/{equipmentId}', [HistoryController::class, 'index'])->name('History.index');
        Route::prefix('Equipments')->group(function () {
            Route::get('All', [EquipmentController::class, 'allEquipments'])->name('Equipments.all');
            Route::get('Hardware', [EquipmentController::class, 'hardware'])->name('Equipments.hardware');
        });
        Route::resource('/Consumables', ConsumablesController::class);


    });
});

Route::get('get_equipments/{personnel_id}', [GetEquipmentsController::class, 'getEquipments']);
