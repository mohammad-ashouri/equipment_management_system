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
        Schema::create('simcards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('number')->unique();
            $table->string('puk');
            $table->string('pin')->nullable();
            $table->string('serial');
            $table->string('type_use');
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });
        EquipmentType::create(['name'=>'simcard','persian_name'=>'سیمکارت']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simcards');
    }
};