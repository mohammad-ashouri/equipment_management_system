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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model')->nullable();
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });
        $query="INSERT INTO cases (brand, model,adder) VALUES
	(11, 'No Model',1),
	(12, 'No Model',1),
	(13, 'No Model',1),
	(14, 'No Model',1),
	(15, 'No Model',1),
	(16, 'No Model',1),
	(17, '2002',1),
	(17, '2009',1),
	(17, 'AVA',1),
	(17, 'X7 Cougar',1),
	(17, 'Pars Evo',1),
	(17, 'Extra 2004',1),
	(17, 'Z2 Hero',1),
	(17, 'Extra 2004',1),
	(17, 'MD 121 Plus',1),
	(17, 'Magnum Plus',1),
	(17, 'Midi 2005 Plus',1),
	(17, 'Midi 6c28',1),
	(17, 'Midi 2002',1),
	(17, 'Oraman',1),
	(17, 'Robin',1),
	(17, 'Pars Plus',1),
	(17, 'Solaris',1),
	(17, 'WEE',1),
	(18, 'Elite Desk 800 G2 SFF',1),
	(18, 'EliteDesk 800  F2 SFF',1),
	(19, 'No Model',1),
	(20, 'No Model',1),
	(21, 'probit',1),
	(22, 'No Model',1),
	(23, 'No Model',1),
	(24, 'No Model',1),
	(25, 'No Model',1),
	(79, 'No Model',1),
	(26, 'No Model',1),
	(27, 'No Model',1),
	(28, 'No Model',1),
	(29, 'No Model',1),
	(30, 'No Model',1),
	(31, 'No Model',1),
	(32, 'No Model',1),
	(33, 'No Model',1),
	(34, 'No Model',1),
	(35, 'No Model',1),
	(36, 'No Model',1),
	(37, 'No Model',1),
	(38, 'No Model',1);
                ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
