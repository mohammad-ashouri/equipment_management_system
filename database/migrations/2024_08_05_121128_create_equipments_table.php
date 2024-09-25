<?php

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel');
            $table->foreign('personnel')->references('id')->on('personnels');
            $table->unsignedBigInteger('equipment_type');
            $table->foreign('equipment_type')->references('id')->on('equipment_types');
            $table->string('property_code')->nullable();
            $table->string('delivery_date');
            $table->json('info');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
