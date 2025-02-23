<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('graphic_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model');
            $table->string('ram_size');
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        $query = "INSERT INTO graphic_cards (brand, model, ram_size, adder) VALUES
	('3', 'NVIDIA GeForce 9400 GT', '512MB',1),
	('3', 'NVIDIA GeForce 6200 TurboCache', '64MB',1),
	('3', 'AMD Radeon HD 5750/6750', '1GB',1),
	('3', 'NVIDIA GeForce 9400 GT', '1GB',1),
	('3', 'NVIDIA GeForce 210 [FAKE]', '1GB',1),
	('3', 'NVIDIA GeForce 9500 GT', '1GB',1),
	('3', 'NVIDIA GeForce 8400 GS G98/D8M', '512MB',1),
	('3', 'NVIDIA GeForce 7300 LE', '256MB',1),
	('3', 'NVIDIA GeForce 8400', '512MB',1),
	('3', 'AMD Radeon X1300', '256MB',1),
	('3', 'NVIDIA GeForce 8400 G98/D8M', '256MB',1),
	('3', 'NVIDIA GeForce GT 610', '2GB',1),
	('3', 'NVIDIA GeForce 9500 GT D9M-30', '512MB',1),
	('3', 'NVIDIA GeForce GT610-SL-2GD3', '2GB',1),
	('3', 'NVIDIA GeForce 8400 GS 512M', '512MB',1),
	('3', 'NVIDIA GeForce 8400 G98/D8M', '512MB',1),
	('3', 'AMD Radeon HD 4350', '512MB',1),
	('3', 'NVIDIA GeForce 8400 GS Rev2', '256MB',1),
	('3', 'AMD Radeon HD 3450/4230/4250', '512MB',1),
	('3', 'NVIDIA GeForce 8400 GS Rev2', '256MB',1),
	('3', 'NVIDIA GeForce 7100 GS NV44', '64MB',1),
	('3', 'NVIDIA GeForce GT 220', '1GB',1),
	('3', 'NVIDIA GeForce 7300 GT', '256MB',1),
	('3', 'NVIDIA GeForce 8400 GT218', '512MB',1),
	('3', 'AMD Radeon HD 5450', '1GB',1),
	('3', 'NVIDIA GeForce 7300 SE G72', '128MB',1),
	('3', 'NVIDIA GeForce 7100 GS', '128MB',1),
	('3', 'NVIDIA GeForce 210', '1GB',1),
	('3', 'NVIDIA GeForce 7300 SE', '256MB',1),
	('3', 'NVIDIA GeForce 7300', '256MB',1),
	('59', 'NVIDIA GeForce 8400 GS', '512MB',1),
	('3', 'NVIDIA GeForce 210 GT218', '1GB',1),
	('3', 'NVIDIA GeForce 9500 GT', '1GB',1),
	('3', 'NVIDIA GeForce 9600 GT G94-300', '1GB',1),
	('3', 'NVIDIA GeForce 7600 GT G73', '256MB',1),
	('3', 'NVIDIA GeForce 6200 TurboCache  NV44', '128MB',1),
	('3', 'NVIDIA GeForce GT 730', '4GB',1),
	('3', 'NVIDIA GeForce 9800 GT', '1GB',1),
	('3', 'NVIDIA Geforce 9500 GT', '1GB',1),
	('57', 'Geforce Biostar GT210', '1GB',1),
	('3', 'NVIDIA GeForce GT 740', '2GB',1),
	('3', 'NVIDIA GeForce 8400 GS', '256MB',1),
	('3', 'AMD Mobility Radeon HD 4570', '1GB',1),
	('3', 'NVIDIA GeForce 8400 G86', '512MB',1),
	('3', 'NVIDIA GeForce GT730', '2GB',1),
	('3', 'NVIDIA GeForce GTX 1660 Super', '6GB',1),
	('3', 'AMD Radeon R7 265/HD 7850', '2GB',1),
	('3', 'NVIDIA GeForce RTX 3060', '12GB',1),
	('3', 'NVIDIA Gefore GT 610', '2GB',1),
	('3', 'AMD Radeon HD 4650', '1GB',1),
	('3', 'NVIDIA GeForce 8400 GS Rev2', '512MB',1),
	('3', 'NVIDIA GeForce GTX 750', '2GB',1);";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graphic_cards');
    }
};
