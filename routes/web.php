<?php

use App\Http\Controllers\Catalogs\BookSubjectController;
use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\BuildingController;
use App\Http\Controllers\Catalogs\PermissionController;
use App\Http\Controllers\Catalogs\PublicationController;
use App\Http\Controllers\Catalogs\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DigitalEquipments\AttendanceSystemController;
use App\Http\Controllers\DigitalEquipments\BatteryChargerController;
use App\Http\Controllers\DigitalEquipments\CameraController;
use App\Http\Controllers\DigitalEquipments\CameraHolderController;
use App\Http\Controllers\DigitalEquipments\CameraLensController;
use App\Http\Controllers\DigitalEquipments\CameraRamController;
use App\Http\Controllers\DigitalEquipments\CctvController;
use App\Http\Controllers\DigitalEquipments\DVBController;
use App\Http\Controllers\DigitalEquipments\ExternalHardDiskController;
use App\Http\Controllers\DigitalEquipments\FlashMemoryController;
use App\Http\Controllers\DigitalEquipments\LaptopController;
use App\Http\Controllers\DigitalEquipments\MicrophoneController;
use App\Http\Controllers\DigitalEquipments\MobileController;
use App\Http\Controllers\DigitalEquipments\PbxController;
use App\Http\Controllers\DigitalEquipments\PhoneController;
use App\Http\Controllers\DigitalEquipments\RecorderController;
use App\Http\Controllers\DigitalEquipments\SatelliteDishController;
use App\Http\Controllers\DigitalEquipments\SatelliteFinderController;
use App\Http\Controllers\DigitalEquipments\SatelliteSwitchController;
use App\Http\Controllers\DigitalEquipments\SetTopBoxController;
use App\Http\Controllers\DigitalEquipments\SimcardController;
use App\Http\Controllers\DigitalEquipments\SoundCardController;
use App\Http\Controllers\DigitalEquipments\SpeakerController;
use App\Http\Controllers\DigitalEquipments\TabletController;
use App\Http\Controllers\DigitalEquipments\UpsController;
use App\Http\Controllers\DigitalEquipments\VideoProjectorController;
use App\Http\Controllers\DigitalEquipments\VideoProjectorCurtainController;
use App\Http\Controllers\DigitalEquipments\WebcamController;
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
use App\Http\Controllers\NetworkEquipments\AccessPointController;
use App\Http\Controllers\NetworkEquipments\CableTesterController;
use App\Http\Controllers\NetworkEquipments\DongleController;
use App\Http\Controllers\NetworkEquipments\KvmController;
use App\Http\Controllers\NetworkEquipments\LantvController;
use App\Http\Controllers\NetworkEquipments\LmbController;
use App\Http\Controllers\NetworkEquipments\ModemController;
use App\Http\Controllers\NetworkEquipments\NetworkCardController;
use App\Http\Controllers\NetworkEquipments\NvrController;
use App\Http\Controllers\NetworkEquipments\PunchWrenchController;
use App\Http\Controllers\NetworkEquipments\RackControllers;
use App\Http\Controllers\NetworkEquipments\RadioWirelessController;
use App\Http\Controllers\NetworkEquipments\RouterController;
use App\Http\Controllers\NetworkEquipments\SocketWrenchController;
use App\Http\Controllers\NetworkEquipments\StripperWrenchController;
use App\Http\Controllers\NetworkEquipments\SwitchController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\Reports\ConsumablesController;
use App\Http\Controllers\Reports\DatabaseBackupController;
use App\Http\Controllers\Reports\EquipmentController;
use App\Http\Controllers\Reports\HistoryController;
use App\Http\Controllers\TechnicalFacilities\AirConditionerController;
use App\Http\Controllers\TechnicalFacilities\BedController;
use App\Http\Controllers\TechnicalFacilities\BlowerController;
use App\Http\Controllers\TechnicalFacilities\BookController;
use App\Http\Controllers\TechnicalFacilities\BracketController;
use App\Http\Controllers\TechnicalFacilities\ChairController;
use App\Http\Controllers\TechnicalFacilities\ClosetController;
use App\Http\Controllers\TechnicalFacilities\CoatHangerController;
use App\Http\Controllers\TechnicalFacilities\DrawerFileCabinetController;
use App\Http\Controllers\TechnicalFacilities\ElectricPanelController;
use App\Http\Controllers\TechnicalFacilities\FanController;
use App\Http\Controllers\TechnicalFacilities\FireExtinguisherController;
use App\Http\Controllers\TechnicalFacilities\FlashlightController;
use App\Http\Controllers\TechnicalFacilities\FlowerPotController;
use App\Http\Controllers\TechnicalFacilities\FrontFurnitureTableController;
use App\Http\Controllers\TechnicalFacilities\HeaterController;
use App\Http\Controllers\TechnicalFacilities\HotGlueBindingController;
use App\Http\Controllers\TechnicalFacilities\KeyBoxController;
use App\Http\Controllers\TechnicalFacilities\LadderController;
use App\Http\Controllers\TechnicalFacilities\LaminatingMachineController;
use App\Http\Controllers\TechnicalFacilities\LibraryController;
use App\Http\Controllers\TechnicalFacilities\MicrowaveController;
use App\Http\Controllers\TechnicalFacilities\MihrabController;
use App\Http\Controllers\TechnicalFacilities\NoticeboardController;
use App\Http\Controllers\TechnicalFacilities\OvenController;
use App\Http\Controllers\TechnicalFacilities\PaperCutterController;
use App\Http\Controllers\TechnicalFacilities\PingPongTableController;
use App\Http\Controllers\TechnicalFacilities\RefrigeratorController;
use App\Http\Controllers\TechnicalFacilities\SafeController;
use App\Http\Controllers\TechnicalFacilities\SamovarController;
use App\Http\Controllers\TechnicalFacilities\ShoeCabinetController;
use App\Http\Controllers\TechnicalFacilities\ShredderController;
use App\Http\Controllers\TechnicalFacilities\SpringBindingController;
use App\Http\Controllers\TechnicalFacilities\SuggestionBoxController;
use App\Http\Controllers\TechnicalFacilities\TableController;
use App\Http\Controllers\TechnicalFacilities\TeaMakerController;
use App\Http\Controllers\TechnicalFacilities\TelevisionController;
use App\Http\Controllers\TechnicalFacilities\ThermometerController;
use App\Http\Controllers\TechnicalFacilities\VaccumCleanerController;
use App\Http\Controllers\TechnicalFacilities\WaterDispenserController;
use App\Http\Controllers\TechnicalFacilities\WaterPurifierController;
use App\Http\Controllers\TechnicalFacilities\WhiteboardController;
use App\Http\Controllers\TechnicalFacilities\WhiteboardHolderController;
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
        Route::resources([
            '/Monitors' => MonitorController::class,
            '/Cases' => CaseController::class,
            '/Cpus' => CpuController::class,
            '/Motherboards' => MotherboardController::class,
            '/Powers' => PowerController::class,
            '/Rams' => RamController::class,
            '/GraphicCards' => GraphicCardController::class,
            '/InternalHardDisks' => InternalHardDiskController::class,
            '/Odds' => OddController::class,
            '/Mouses' => MouseController::class,
            '/Keyboards' => KeyboardController::class,
            '/Headsets' => HeadsetController::class,
            '/Printers' => PrinterController::class,
            '/Scanners' => ScannerController::class,
            '/CopyMachines' => CopyMachineController::class,
            '/Voips' => VoipController::class,
        ]);


        //Network Equipments
        Route::resources([
            '/NetworkCards' => NetworkCardController::class,
            '/Modems' => ModemController::class,
            '/Switches' => SwitchController::class,
            '/Racks' => RackControllers::class,
            '/Dongles' => DongleController::class,
            '/PunchWrenches' => PunchWrenchController::class,
            '/SocketWrenches' => SocketWrenchController::class,
            '/StripperWrenches' => StripperWrenchController::class,
            '/CableTesters' => CableTesterController::class,
            '/Kvms' => KvmController::class,
            '/Lantvs' => LantvController::class,
            '/RadioWirelesses' => RadioWirelessController::class,
            '/AccessPoints' => AccessPointController::class,
            '/Routers' => RouterController::class,
        ]);


        //Digital Equipments
        Route::resources([
            '/ExternalHardDisks' => ExternalHardDiskController::class,
            '/Phones' => PhoneController::class,
            '/Mobiles' => MobileController::class,
            '/Tablets' => TabletController::class,
            '/DVBs' => DVBController::class,
            '/CameraHolders' => CameraHolderController::class,
            '/Simcards' => SimcardController::class,
            '/Speakers' => SpeakerController::class,
            '/AttendanceSystems' => AttendanceSystemController::class,
            '/Cctvs' => CctvController::class,
            '/Recorders' => RecorderController::class,
            '/Webcams' => WebcamController::class,
            '/FlashMemories' => FlashMemoryController::class,
            '/Ups' => UpsController::class,
            '/SatelliteDishes' => SatelliteDishController::class,
            '/CameraLenses' => CameraLensController::class,
            '/SatelliteFinders' => SatelliteFinderController::class,
            '/SoundCards' => SoundCardController::class,
            '/VideoProjectors' => VideoProjectorController::class,
            '/VideoProjectorCurtains' => VideoProjectorCurtainController::class,
            '/Microphones' => MicrophoneController::class,
            '/BatteryChargers' => BatteryChargerController::class,
            '/Cameras' => CameraController::class,
            '/Laptops' => LaptopController::class,
        ]);


        //TechnicalFacilities
        Route::resources([
            '/Chairs' => ChairController::class,
            '/Tables' => TableController::class,
            '/FireExtinguishers' => FireExtinguisherController::class,
            '/Refrigerators' => RefrigeratorController::class,
            '/Blowers' => BlowerController::class,
            '/KeyBoxes' => KeyBoxController::class,
            '/DrawerFileCabinets' => DrawerFileCabinetController::class,
            '/AirConditioners' => AirConditionerController::class,
            '/Heaters' => HeaterController::class,
            '/Televisions' => TelevisionController::class,
            '/Ladders' => LadderController::class,
            '/PingPongTables' => PingPongTableController::class,
            '/Microwaves' => MicrowaveController::class,
            '/Fans' => FanController::class,
            '/VaccumCleaners' => VaccumCleanerController::class,
            '/CoatHangers' => CoatHangerController::class,
            '/Shredders' => ShredderController::class,
            '/Ovens' => OvenController::class,
            '/WaterPurifiers' => WaterPurifierController::class,
            '/TeaMakers' => TeaMakerController::class,
            '/Samovars' => SamovarController::class,
            '/Whiteboards' => WhiteboardController::class,
            '/WaterDispensers' => WaterDispenserController::class,
            '/Noticeboards' => NoticeboardController::class,
            '/PaperCutters' => PaperCutterController::class,
            '/SpringBindings' => SpringBindingController::class,
            '/HotGlueBindings' => HotGlueBindingController::class,
            '/SuggestionBoxes' => SuggestionBoxController::class,
            '/Closets' => ClosetController::class,
            '/LaminatingMachines' => LaminatingMachineController::class,
            '/Libraries' => LibraryController::class,
            '/Beds' => BedController::class,
            '/FrontFurnitureTables' => FrontFurnitureTableController::class,
            '/Books' => BookController::class,
            '/WhiteboardHolders' => WhiteboardHolderController::class,
            '/ShoeCabinets' => ShoeCabinetController::class,
            '/Safes' => SafeController::class,
            '/Thermometers' => ThermometerController::class,
            '/ElectricPanels' => ElectricPanelController::class,
            '/Flashlights' => FlashlightController::class,
            '/Mihrabs' => MihrabController::class,
            '/Brackets' => BracketController::class,
            '/FlowerPots' => FlowerPotController::class,
            '/CameraRams' => CameraRamController::class,
            '/Pbxes' => PbxController::class,
            '/SatelliteSwitches' => SatelliteSwitchController::class,
            '/Nvrs' => NvrController::class,
            '/Lmbs' => LmbController::class,
            '/SetTopBoxes' => SetTopBoxController::class,
        ]);


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
        });
        Route::resource('/Consumables',ConsumablesController::class);
    });
});

