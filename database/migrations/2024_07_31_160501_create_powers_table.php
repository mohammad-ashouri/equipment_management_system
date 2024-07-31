<?php

use App\Models\HardwareEquipments\Power;
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
        Schema::create('powers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model')->nullable();
            $table->integer('voltage')->nullable();
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        $voltages = [
            '400', '320', '335', '370', '330', '350', '380', '430', '460', '470',
            '300', '350', '360', '420', '480', '485', '500', '530', '535', '550',
            '580', '600', '650', '685'
        ];
        $companies = [
            2, 3, 4, 5, 17,
            7, 27, 8, 9, 10, 35
        ];

        foreach ($companies as $company) {
            foreach ($voltages as $voltage) {
                Power::create([
                    'brand' => $company,
                    'voltage' => $voltage,
                    'adder' => 1,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powers');
    }
};
