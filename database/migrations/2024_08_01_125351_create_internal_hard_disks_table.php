<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internal_hard_disks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model');
            $table->string('capacity');
            $table->string('connectivity_type');
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });
        $query = "INSERT INTO internal_hard_disks (brand,model,capacity,connectivity_type,adder) values
                                                      (43,'980 Pro','1TB','Onboard',1),
                                                      (50,'SU800','256GB','Onboard',1),
                                                      (49,'-','128GB','Onboard',1),
                                                      (49,'-','250GB','Onboard',1),
                                                      (49,'-','256GB','Onboard',1),
                                                      (49,'-','512GB','Onboard',1),
                                                      (49,'-','1TB','Onboard',1),
                                                      (49,'-','2TB','Onboard',1),
                                                      (54,'-','128GB','SATA',1),
                                                      (54,'-','250GB','SATA',1),
                                                      (54,'-','256GB','SATA',1),
                                                      (54,'-','512GB','SATA',1),
                                                      (54,'-','1TB','SATA',1),
                                                      (54,'-','2TB','SATA',1),
                                                      (47,'Green','500GB','SATA',1),
                                                      (47,'Green','1TB','SATA',1),
                                                      (47,'Green','2TB','SATA',1),
                                                      (47,'Blue','500GB','SATA',1),
                                                      (47,'Blue','1TB','SATA',1),
                                                      (47,'Blue','2TB','SATA',1),
                                                      (47,'Purple','500GB','SATA',1),
                                                      (47,'Purple','1TB','SATA',1),
                                                      (47,'Purple','2TB','SATA',1)
                                                      ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_hard_disks');
    }
};
