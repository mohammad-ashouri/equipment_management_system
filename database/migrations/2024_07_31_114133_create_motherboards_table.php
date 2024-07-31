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
        Schema::create('motherboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model');
            $table->string('generation')->nullable();
            $table->integer('cpu_slot_type')->nullable();
            $table->integer('cpu_slots_number')->nullable();
            $table->integer('ram_slots_number')->nullable();
            $table->string('ram_slot_type')->nullable();
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        $query = "INSERT INTO motherboards (brand, model,adder)
VALUES
(56, 'I-G31',1),
(56, 'IX38-QuadGT',1),
(62, '4Core1600Twins-P35',1),
(62, 'G31M-S',1),
(62, 'Intel 945P',1),
(62, 'P43DE3L',1),
(62, 'P85 Pro3',1),
(62, 'wolfdalel333d',1),
(62, 'Yorkf wolfdale',1),
(3, 'B75M-A',1),
(3, 'B85 PLUS',1),
(3, 'B85-PLUS/USB 3.1',1),
(3, 'H610M-A',1),
(3, 'H61M-C',1),
(3, 'H61M-E',1),
(3, 'H81M-C',1),
(3, 'M4A78',1),
(3, 'M4A78LT-M-LE',1),
(3, 'M4A88TD-V EVO/USB3',1),
(3, 'M4N78 PRO',1),
(3, 'M4N78 SE',1),
(3, 'P5G41C-M LX',1),
(3, 'P5G41T-M LX',1),
(3, 'P5G41T-M LX3',1),
(3, 'P5GC-MX',1),
(3, 'P5GC-MX/1333',1),
(3, 'P5KPL',1),
(3, 'P5KPL AM-SE',1),
(3, 'P5KPL/1600',1),
(3, 'P5KPL-AM',1),
(3, 'P5KPL-AM EPU',1),
(3, 'P5KPL-SE',1),
(3, 'P5LD2-SE',1),
(3, 'P5P41T-LE',1),
(3, 'P5PL2-E',1),
(3, 'P5Q',1),
(3, 'P5QC',1),
(3, 'P5QL-ASUS-SE',1),
(3, 'P6T',1),
(3, 'P7P55 LX',1),
(3, 'P8B75-V',1),
(3, 'P8H61-M LE',1),
(3, 'P8H61-M LX',1),
(3, 'P8H61-M LX R2.0',1),
(3, 'P8H61-M LX2',1),
(3, 'P8P67LE',1),
(3, 'PRIME B360-PLUS',1),
(3, 'PRIME H310M-A R2.0',1),
(3, 'PRIME H310-PLUS',1),
(3, 'PRIME Z490-P',1),
(3, 'TUF GAMING Z590-PLUS WIFI',1),
(3, 'Z97-A',1),
(3, 'Z97-PRO',1),
(57, '945P-A7B',1),
(57, 'G41T-M13',1),
(57, 'Group G41D3',1),
(57, 'Group G41-M7',1),
(57, 'Group N68S3+',1),
(57, 'Group P41D3',1),
(57, 'Group TPower I45',1),
(58, '945PT-A2',1),
(58, 'A780GM-A',1),
(58, 'A785GM-AD3 Black Series',1),
(58, 'G41T-M12',1),
(58, 'G41T-M13',1),
(58, 'Geforce 8200 A Black Series',1),
(58, 'H61H2-M3',1),
(59, 'A7DA 3 series',1),
(59, 'P45A01',1),
(59, 'P31_ICH7',1),
(16, '8I865GME-775-RH R2.0',1),
(16, '945GZM-S2',1),
(16, '945PLM-S2',1),
(16, 'EP31-DS3L',1),
(16, 'EP41-UD3L',1),
(16, 'EP43-DS3L',1),
(16, 'G31M-S2C',1),
(16, 'G31M-S2L',1),
(16, 'G41M-ES2L',1),
(16, 'G41MT-D3',1),
(16, 'G41MT-S2',1),
(16, 'G41MT-S2P',1),
(16, 'G41MT-S2PT',1),
(16, 'GA-H61MA-D2V',1),
(16, 'GA-P31-ES3G',1),
(16, 'H110M-S2PH-CF',1),
(16, 'H170-HD3-CF',1),
(16, 'H55M-S2',1),
(16, 'H55M-S2H',1),
(16, 'H61MA-D2V',1),
(16, 'H61M-S2P',1),
(16, 'H61M-S2P REV 3.0',1),
(16, 'H61M-S2P-R3',1),
(16, 'H61M-S2PT',1),
(16, 'H61M-S2PV REV 2.2',1),
(16, 'H61M-USB3-B3',1),
(16, 'H61M-WW',1),
(16, 'H81M-S2PT',1),
(16, 'H81M-S2PV',1),
(16, 'P31-ES3G',1),
(16, 'P35-DS3L',1),
(16, 'P41T-D3',1),
(16, 'P43T-ES3G',1),
(16, 'P55-UD3L',1),
(16, 'P75-D3',1),
(16, '954PL-S3',1),
(16, 'Z97-D3H-CF',1),
(16, 'Z68A-D3-B3',1),
(16, 'Z87-HD3',1),
(18, '8054',1),
(18, '805D',1),
(60, 'MS-7369',1),
(60, 'MS-7267',1),
(60, 'H61M-P23 (MS-7680)',1),
(60, 'G41M-P26 (MS-7592)',1),
(60, '880GM-E41 (MS-7623)',1),
(61, 'TI41M',1),
(61, 'MIG41TM/MIG41TM V2',1),
(39, 'H55 (IbexPeak DH)',1),
(39, 'G31 (Bearlake) + ICH7)',1),
(39, 'DP43TF',1),
(39, 'H61MA-D2V',1),
(39, '945PL (Lakeport-PL) + ICH7',1);
";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboards');
    }
};
