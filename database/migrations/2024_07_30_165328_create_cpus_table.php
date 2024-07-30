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
        Schema::create('cpus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model');
            $table->integer('generation')->nullable();
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });
        $query = "INSERT INTO cpus (brand, model, adder) VALUES
	('39', 'Pentium Dual Core E5200',1),
	('40', 'Athlon II X2 560',1),
	('39', 'Pentium Dual Core E5300',1),
	('39', 'Pentium Dual Core E5200',1),
	('39', 'Pentium Dual Core E5700',1),
	('40', 'Athlon II X2 250',1),
	('39', 'Core 2 Duo E7300',1),
	('40', 'Athlon II X2 240',1),
	('40', 'Athlon II X4 970 Black Edition',1),
	('39', 'Core 2 Duo E7400',1),
	('39', 'Pentium G630',1),
	('39', 'Pentium Dual Core E6600',1),
	('39', 'Core 2 Duo E7500',1),
	('39', 'Core 2 Quad Q8200',1),
	('39', 'Pentium Dual Core E2200',1),
	('39', 'Pentium 4 631',1),
	('39', 'Pentium 4 630',1),
	('39', 'Pentium 4 631',1),
	('39', 'Core 2 Duo E8400',1),
	('39', 'Core 2 Quad Q6700',1),
	('39', 'Pentium Dual Core E2180',1),
	('39', 'Core 2 Quad Q6600',1),
	('39', 'Pentium G3220',1),
	('39', 'Core i3-540',1),
	('39', 'Pentium Dual Core E6300',1),
	('39', 'Pentium 4 661',1),
	('39', 'Pentium G620',1),
	('39', 'Pentium 4 651',1),
	('40', 'Athlon II X2 245',1),
	('39', 'Pentium Dual Core E5500',1),
	('39', 'Pentium Dual Core E6700',1),
	('39', 'Core 2 Duo E6750',1),
	('39', 'Pentium Dual Core E6500',1),
	('39', 'Core 2 Duo E6300',1),
	('40', 'Athlon 64 X2 5000+',1),
	('39', 'Pentium Dual Core E5400',1),
	('39', 'Pentium G840',1),
	('40', 'Athlon II X4 620',1),
	('39', 'Core i3-4160',1),
	('39', 'Core i7-870',1),
	('39', 'Pentium G645',1),
	('39', 'Pentium 4 641',1),
	('39', 'Core i3-12100',1),
	('39', 'Core i5-6500',1),
	('39', 'Pentium G2020',1),
	('39', 'Celeron 420',1),
	('40', 'Sempron 145',1),
	('39', 'Core i5-4460',1),
	('39', 'Core i7-2600',1),
	('39', 'Core i3-4150',1),
	('39', 'Core i3-4170',1),
	('39', 'Core i3-8100',1),
	('39', 'Pentium G2030 ',1),
	('39', 'Core i3-3210',1),
	('39', 'Pentium 4 524',1),
	('39', 'Core i3-7100',1),
	('39', 'Pentium G2030',1),
	('39', 'Core i3-9100',1),
	('39', 'Core i7-4770',1),
	('39', 'Core i5-760',1),
	('39', 'Core i3-3240',1),
	('39', 'Core i3-2120',1),
	('39', 'Core i3-3220',1),
	('39', 'Core i7-4790',1),
	('39', 'Core i7-4790K',1),
	('39', 'Core i7-2600K',1),
	('39', 'Core i7-930',1),
	('39', 'Core i3-6098P',1),
	('39', 'Core i5-6600',1),
	('39', 'Core i7-3770',1),
	('39', 'Core i7-10700',1),
	('39', 'Core i9-11900K',1),
	('39', 'Celeron G1610',1),
	('39', 'Pentium D 945',1),
	('39', 'Core i3-4160',1),
	('39', 'Core i5-3570K',1),
	('39', 'Dual Core E5700',1);
";

        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpus');
    }
};
