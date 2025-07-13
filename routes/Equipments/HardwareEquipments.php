<?php

use App\Http\Controllers\HardwareEquipments\CaseController;
use App\Http\Controllers\HardwareEquipments\CopyMachineController;
use App\Http\Controllers\HardwareEquipments\CpuController;
use App\Http\Controllers\HardwareEquipments\ExternalWriterController;
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
use Illuminate\Support\Facades\Route;

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
    '/ExternalWriters' => ExternalWriterController::class,
]);
