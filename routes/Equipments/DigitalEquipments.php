<?php

use App\Http\Controllers\DigitalEquipments\AttendanceSystemController;
use App\Http\Controllers\DigitalEquipments\BatteryChargerController;
use App\Http\Controllers\DigitalEquipments\CameraController;
use App\Http\Controllers\DigitalEquipments\CameraHolderController;
use App\Http\Controllers\DigitalEquipments\CameraLensController;
use App\Http\Controllers\DigitalEquipments\CctvController;
use App\Http\Controllers\DigitalEquipments\DigitalPenController;
use App\Http\Controllers\DigitalEquipments\DVBController;
use App\Http\Controllers\DigitalEquipments\ExternalHardDiskController;
use App\Http\Controllers\DigitalEquipments\FlashMemoryController;
use App\Http\Controllers\DigitalEquipments\LaptopController;
use App\Http\Controllers\DigitalEquipments\MicrophoneController;
use App\Http\Controllers\DigitalEquipments\MobileController;
use App\Http\Controllers\DigitalEquipments\PhoneController;
use App\Http\Controllers\DigitalEquipments\RecorderController;
use App\Http\Controllers\DigitalEquipments\SatelliteDishController;
use App\Http\Controllers\DigitalEquipments\SatelliteFinderController;
use App\Http\Controllers\DigitalEquipments\SimcardController;
use App\Http\Controllers\DigitalEquipments\SoundCardController;
use App\Http\Controllers\DigitalEquipments\SpeakerController;
use App\Http\Controllers\DigitalEquipments\TabletController;
use App\Http\Controllers\DigitalEquipments\UpsController;
use App\Http\Controllers\DigitalEquipments\VideoProjectorController;
use App\Http\Controllers\DigitalEquipments\VideoProjectorCurtainController;
use App\Http\Controllers\DigitalEquipments\WebcamController;
use Illuminate\Support\Facades\Route;

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
    '/DigitalPens' => DigitalPenController::class,
]);
