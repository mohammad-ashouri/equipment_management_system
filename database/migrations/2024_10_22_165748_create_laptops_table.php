<?php

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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model');
            $table->float('monitor_size');
            $table->unsignedBigInteger('cpu');
            $table->foreign('cpu')->references('id')->on('cpus');
            $table->unsignedBigInteger('graphic_card');
            $table->foreign('graphic_card')->references('id')->on('graphic_cards');
            $table->string('odd')->default('ندارد');
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
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
        Schema::dropIfExists('laptops');
    }
};
