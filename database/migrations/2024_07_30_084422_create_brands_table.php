<?php

use App\Models\Catalogs\Brand;
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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        $query = "
INSERT INTO brands (name, adder)
VALUES
    ('Acbel',1),
('Asus',1),
('Coolermaster',1),
('GLT',1),
('Hreen',1),
('Memonex',1),
('RedMax',1),
('SilverStone',1),
('Thermaltake',1),
('Apex',1),
('Comport',1),
('Delux',1),
('Digital',1),
('Elegance',1),
('Gigabyte',1),
('Green',1),
('HP',1),
('Lexus',1),
('Logic',1),
('Microlab',1),
('Micronet',1),
('mingo',1),
('Napex',1),
('Next',1),
('Optima',1),
('Pascal',1),
('Perfect',1),
('Power Media',1),
('Protect',1),
('RHOMBUS',1),
('Select',1),
('TANUS',1),
('Target',1),
('TSCO',1),
('VANIA',1),
('Viera',1),
('Winext',1),
('Intel',1),
('AMD',1),
('Hitachi',1),
('Maxtor',1),
('Samsung',1),
('Seagate',1),
('simmtronics',1),
('Toshiba',1),
('Western Digital',1),
('White Label',1),
('Lexar',1),
('ADATA',1),
('Gloway',1),
('kingmax',1),
('Kingstone',1),
('PNY',1),
('Apacer',1),
('Abit',1),
('Biostar',1),
('ECS',1),
('Foxconn',1),
('MSI',1),
('JETWAY',1),
('Asrock',1),
('AOC',1),
('CMV',1),
('DETIG',1),
('GPLUS',1),
('LG',1),
('Philips',1),
('Xvision',1),
('Brother',1),
('Canon',1),
('Advision',1),
('Epson',1),
('Fujitsu',1),
('Kodak',1),
('Plustek',1),
('Bizhub',1),
('Sharp',1),
('No Name',1),
('Cisco',1),
('SONY',1),
('Corsair',1),
('Corsair',1),
('همراه اول',1),
('ایرانسل',1),
('رایتل',1),
('اسپادان',1),
('تله کیش',1),
('سامانتل',1),
('شاتل موبایل',1),
('آپتل',1),
('تالیا',1),
('لوتوس تل',1)
;
";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
