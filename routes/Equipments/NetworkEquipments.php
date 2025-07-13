<?php

use App\Http\Controllers\DigitalEquipments\CameraSliderController;
use App\Http\Controllers\NetworkEquipments\AccessPointController;
use App\Http\Controllers\NetworkEquipments\CableTesterController;
use App\Http\Controllers\NetworkEquipments\DongleController;
use App\Http\Controllers\NetworkEquipments\KvmController;
use App\Http\Controllers\NetworkEquipments\LantvController;
use App\Http\Controllers\NetworkEquipments\ModemController;
use App\Http\Controllers\NetworkEquipments\NetworkCardController;
use App\Http\Controllers\NetworkEquipments\PunchWrenchController;
use App\Http\Controllers\NetworkEquipments\RackControllers;
use App\Http\Controllers\NetworkEquipments\RadioWirelessController;
use App\Http\Controllers\NetworkEquipments\RouterController;
use App\Http\Controllers\NetworkEquipments\ServerController;
use App\Http\Controllers\NetworkEquipments\SocketWrenchController;
use App\Http\Controllers\NetworkEquipments\StorageController;
use App\Http\Controllers\NetworkEquipments\StripperWrenchController;
use App\Http\Controllers\NetworkEquipments\SwitchController;
use Illuminate\Support\Facades\Route;

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
    '/CameraSliders' => CameraSliderController::class,
    '/Servers' => ServerController::class,
    '/Storages' => StorageController::class,
]);
