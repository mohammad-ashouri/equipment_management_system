<?php

use App\Http\Controllers\DigitalEquipments\BatteryCabinetController;
use App\Http\Controllers\DigitalEquipments\CameraRamController;
use App\Http\Controllers\DigitalEquipments\LightController;
use App\Http\Controllers\DigitalEquipments\LightHolderController;
use App\Http\Controllers\DigitalEquipments\PbxController;
use App\Http\Controllers\DigitalEquipments\SatelliteSwitchController;
use App\Http\Controllers\DigitalEquipments\SetTopBoxController;
use App\Http\Controllers\NetworkEquipments\LmbController;
use App\Http\Controllers\NetworkEquipments\NvrController;
use App\Http\Controllers\TechnicalFacilities\AirConditionerController;
use App\Http\Controllers\TechnicalFacilities\BedController;
use App\Http\Controllers\TechnicalFacilities\BlowerController;
use App\Http\Controllers\TechnicalFacilities\BookController;
use App\Http\Controllers\TechnicalFacilities\BracketController;
use App\Http\Controllers\TechnicalFacilities\ChairController;
use App\Http\Controllers\TechnicalFacilities\ClosetController;
use App\Http\Controllers\TechnicalFacilities\CoatHangerController;
use App\Http\Controllers\TechnicalFacilities\CouchController;
use App\Http\Controllers\TechnicalFacilities\DrawerFileCabinetController;
use App\Http\Controllers\TechnicalFacilities\ElectricPanelController;
use App\Http\Controllers\TechnicalFacilities\FanController;
use App\Http\Controllers\TechnicalFacilities\FireExtinguisherController;
use App\Http\Controllers\TechnicalFacilities\FlashlightController;
use App\Http\Controllers\TechnicalFacilities\FlowerPotController;
use App\Http\Controllers\TechnicalFacilities\FrontFurnitureTableController;
use App\Http\Controllers\TechnicalFacilities\HeaterController;
use App\Http\Controllers\TechnicalFacilities\HotGlueBindingController;
use App\Http\Controllers\TechnicalFacilities\IranianCoolerController;
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
use Illuminate\Support\Facades\Route;

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
    '/LightHolders' => LightHolderController::class,
    '/BatteryCabinets' => BatteryCabinetController::class,
    '/Lights' => LightController::class,
    '/IranianCoolers' => IranianCoolerController::class,
    '/Couches' => CouchController::class,
]);
