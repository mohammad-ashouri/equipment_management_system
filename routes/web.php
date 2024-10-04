<?php

use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\BuildingController;
use App\Http\Controllers\Catalogs\PermissionController;
use App\Http\Controllers\Catalogs\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DigitalEquipments\CameraHolderController;
use App\Http\Controllers\DigitalEquipments\DVBController;
use App\Http\Controllers\DigitalEquipments\ExternalHardDiskController;
use App\Http\Controllers\DigitalEquipments\MobileController;
use App\Http\Controllers\DigitalEquipments\PhoneController;
use App\Http\Controllers\DigitalEquipments\SimcardController;
use App\Http\Controllers\DigitalEquipments\TabletController;
use App\Http\Controllers\DigitalEquipments\TelevisionController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\HardwareEquipments\CaseController;
use App\Http\Controllers\HardwareEquipments\CopyMachineController;
use App\Http\Controllers\HardwareEquipments\CpuController;
use App\Http\Controllers\HardwareEquipments\GraphicCardController;
use App\Http\Controllers\HardwareEquipments\HeadsetController;
use App\Http\Controllers\HardwareEquipments\InternalHardDiskController;
use App\Http\Controllers\HardwareEquipments\KeyboardController;
use App\Http\Controllers\HardwareEquipments\MonitorController;
use App\Http\Controllers\HardwareEquipments\MotherboardController;
use App\Http\Controllers\HardwareEquipments\MouseController;
use App\Http\Controllers\HardwareEquipments\OddController;
use App\Http\Controllers\HardwareEquipments\PowerController;
use App\Http\Controllers\HardwareEquipments\PrinterController;
use App\Http\Controllers\HardwareEquipments\RamController;
use App\Http\Controllers\HardwareEquipments\ScannerController;
use App\Http\Controllers\HardwareEquipments\VoipController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NetworkEquipments\CableTesterController;
use App\Http\Controllers\NetworkEquipments\DongleController;
use App\Http\Controllers\NetworkEquipments\KvmController;
use App\Http\Controllers\NetworkEquipments\LantvController;
use App\Http\Controllers\NetworkEquipments\ModemController;
use App\Http\Controllers\NetworkEquipments\NetworkCardController;
use App\Http\Controllers\NetworkEquipments\PunchWrenchController;
use App\Http\Controllers\NetworkEquipments\RackControllers;
use App\Http\Controllers\NetworkEquipments\SocketWrenchController;
use App\Http\Controllers\NetworkEquipments\StripperWrenchController;
use App\Http\Controllers\NetworkEquipments\SwitchController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\Reports\DatabaseBackupController;
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

        //Hardware Equipments
        Route::resource('/Monitors', MonitorController::class);
        Route::resource('/Cases', CaseController::class);
        Route::resource('/Cpus', CpuController::class);
        Route::resource('/Motherboards', MotherboardController::class);
        Route::resource('/Powers', PowerController::class);
        Route::resource('/Rams', RamController::class);
        Route::resource('/GraphicCards', GraphicCardController::class);
        Route::resource('/InternalHardDisks', InternalHardDiskController::class);
        Route::resource('/Odds', OddController::class);
        Route::resource('/Mouses', MouseController::class);
        Route::resource('/Keyboards', KeyboardController::class);
        Route::resource('/Headsets', HeadsetController::class);
        Route::resource('/Printers', PrinterController::class);
        Route::resource('/Scanners', ScannerController::class);
        Route::resource('/CopyMachines', CopyMachineController::class);
        Route::resource('/Voips', VoipController::class);

        //Network Equipments
        Route::resource('/NetworkCards', NetworkCardController::class);
        Route::resource('/Modems', ModemController::class);
        Route::resource('/Switches', SwitchController::class);
        Route::resource('/Racks', RackControllers::class);
        Route::resource('/Dongles', DongleController::class);
        Route::resource('/PunchWrenches', PunchWrenchController::class);
        Route::resource('/SocketWrenches', SocketWrenchController::class);
        Route::resource('/StripperWrenches', StripperWrenchController::class);
        Route::resource('/CableTesters', CableTesterController::class);
        Route::resource('/Kvms', KvmController::class);
        Route::resource('/Lantvs', LantvController::class);

        //Digital Equipments
        Route::resource('/ExternalHardDisks', ExternalHardDiskController::class);
        Route::resource('/Phones', PhoneController::class);
        Route::resource('/Televisions', TelevisionController::class);
        Route::resource('/Mobiles', MobileController::class);
        Route::resource('/Tablets', TabletController::class);
        Route::resource('/DVBs', DVBController::class);
        Route::resource('/CameraHolders', CameraHolderController::class);
        Route::resource('/Simcards', SimcardController::class);

        //Personnels
        Route::resource('/Personnels', PersonnelController::class);
        Route::get('/Personnels/{personnel}/equipments', [EquipmentsController::class, 'equipments'])->name('Personnels.equipments');
        Route::get('/Personnels/{personnel}/equipments/new/{equipmentType}', [EquipmentsController::class, 'newEquipment'])->name('Personnels.equipments.new');
        Route::post('/Personnels/equipments/new', [EquipmentsController::class, 'storeEquipment'])->name('Personnels.equipments.store');
        Route::get('/Personnels/{personnel}/equipments/edit/{equipmentId}', [EquipmentsController::class, 'editEquipment'])->name('Personnels.equipments.edit');
        Route::post('/Personnels/equipments/update', [EquipmentsController::class, 'updateEquipment'])->name('Personnels.equipments.update');
        Route::post('/Personnels/equipments/move', [EquipmentsController::class, 'moveEquipment'])->name('Personnels.equipments.move');

        //Reports
        Route::prefix('BackupDatabase')->group(function () {
            Route::get('/', [DatabaseBackupController::class, 'index']);
            Route::post('/', [DatabaseBackupController::class, 'createBackup']);
        });
        Route::get('/ChangeHistory/{personnel}/{equipmentId}', [HistoryController::class, 'index'])->name('History.index');
    });
});

