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
        Schema::create('person_adjectives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });
        DB::table('person_adjectives')->insert(['name'=>'دکتر','adder'=>1]);
        DB::table('person_adjectives')->insert(['name'=>'حجت الاسلام','adder'=>1]);
        DB::table('person_adjectives')->insert(['name'=>'حجت الاسلام و المسلمین','adder'=>1]);
        DB::table('person_adjectives')->insert(['name'=>'حجت الاسلام و المسلمین دکتر','adder'=>1]);
        DB::table('person_adjectives')->insert(['name'=>'جناب آقای','adder'=>1]);
        DB::table('person_adjectives')->insert(['name'=>'سرکار خانم','adder'=>1]);
        DB::table('person_adjectives')->insert(['name'=>'مهندس','adder'=>1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_adjectives');
    }
};
