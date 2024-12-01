<?php

use App\Models\EquipmentType;
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
        Schema::create('monitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand');
            $table->foreign('brand')->references('id')->on('brands');
            $table->string('model');
            $table->float('size');
            $table->boolean('status')->default(1)->comment('1 => active , 0 => deactive');
            $table->unsignedBigInteger('adder');
            $table->foreign('adder')->references('id')->on('users');
            $table->unsignedBigInteger('editor')->nullable();
            $table->foreign('editor')->references('id')->on('users');
            $table->timestamps();
        });

        $query = "INSERT INTO monitors (brand, model, size,adder)
VALUES
(63, '.', 24,1),
(3, 'PA238Q', 23,1),
(43, 'SR19325N', 19,1),
(3, 'VH242', 24,1),
(3, 'VX248', 24,1),
(43, 'E2045NX Plus', 20,1),
(3, 'VX279', 27,1),
(3, '27MX279H', 27,1),
(3, 'MX279', 27,1),
(3, 'MX279H', 27,1),
(3, 'VS228', 22,1),
(64, 'CT-722D', 17,1),
(65, '.', 17,1),
(66, 'GDM-225JN', 22,1),
(66, 'GDM-245LN', 24,1),
(67, 'W1952S', 19,1),
(67, '19M45', 19,1),
(67, '20M44', 20,1),
(67, 'E1950', 19,1),
(67, 'W1954SE', 19,1),
(67, 'W1952SE', 19,1),
(67, '24MP 68VQ', 24,1),
(67, 'E1950S', 19,1),
(67, 'Flatron W1752S', 17,1),
(67, '19EN33', 19,1),
(67, '20MP38B', 20,1),
(67, '20EN32S', 20,1),
(67, '20M35', 20,1),
(67, '20MK400A', 20,1),
(67, '20MK400A-B', 20,1),
(67, '20Mk400H', 20,1),
(67, '20MK400H-B', 20,1),
(67, '20MP38HB', 20,1),
(67, '22MN430M', 22,1),
(67, '23MP67HQ', 23,1),
(67, 'BW1953', 19,1),
(43, 'CW1931', 19,1),
(67, 'E19470', 19,1),
(67, 'E2041', 20,1),
(67, 'E1952SE', 19,1),
(67, 'E20EN32', 20,1),
(67, 'E2040S', 20,1),
(67, 'E19M45', 19,1),
(67, 'Flatron M2394A', 23,1),
(67, 'Flatron L1752S', 17,1),
(67, 'Flatron M1710S', 17,1),
(67, 'Flatron L1710S', 17,1),
(43, 'SA300', 20,1),
(67, 'Flatron W1952s', 19,1),
(67, 'Flatron W1954s', 19,1),
(67, 'L1752S', 17,1),
(67, 'IPS 226', 22,1),
(67, 'M2394A-PT', 23,1),
(43, 'S19C150', 19,1),
(67, 'L1755S', 17,1),
(67, 'W1941S', 19,1),
(67, 'W1942S', 19,1),
(67, 'W1943SE', 19,1),
(67, 'W1953S', 19,1),
(67, 'W1953SE', 19,1),
(67, 'W1954S', 19,1),
(67, 'W1954TE', 19,1),
(67, 'W2053S', 20,1),
(67, 'W2253TQ', 22,1),
(67, 'W1752S', 17,1),
(60, 'Pro MP221', 22,1),
(68, '191EL', 19,1),
(43, 'BN1955+', 19,1),
(43, 'AWX1943', 19,1),
(43, 'LA22B690T6S', 22,1),
(43, 'S22D300', 22,1),
(43, 'SyncMaster E1920', 19,1),
(43, '1732N Plus', 17,1),
(43, '2033SN', 23,1),
(43, '2233', 22,1),
(43, 'Sync Master 720N', 17,1),
(69, 'XL1910AL', 19,1),
(43, 'S19RC25N', 19,1),
(69, 'XL2020AI', 20,1),
(69, 'XT2210H', 22,1),
(43, 'S24D595P Plus', 24,1),
(43, 'NW1943 Plus', 19,1),
(43, 'BM1943', 19,1),
(43, 'Sync Master T200', 20,1),
(43, 'Sync Master P20500', 20,1),
(43, 'Sync Master NX 1743 Plus', 17,1),
(43, 'Sync Master M1740', 17,1),
(43, 'Sync Master N1750 Plus', 17,1),
(43, 'S24D395H Plus', 24,1),
(43, 'S20H325B Plus', 20,1),
(43, 'S19V315N Plus', 19,1),
(43, 'S19R325N Plus', 19,1),
(43, 'S20H325B', 20,1),
(43, 'T1900 P', 19,1),
(43, 'S19R325N', 19,1),
(43, 'S19C325N Plus', 19,1),
(43, 'S19R315N', 19,1),
(43, 'S19B315N Plus', 19,1),
(43, 'S19C325N', 19,1),
(43, 'P20500', 20,1),
(43, 'S19B315N', 19,1),
(43, 'NW1943', 19,1),
(43, 'NX1743', 17,1),
(43, 'NW1733', 17,1),
(43, 'NW1932Plus', 19,1),
(43, 'BX2031', 20,1),
(43, 'BW1932', 19,1),
(43, 'BX1980N Plus', 19,1),
(43, 'B1955N Plus', 19,1),
(43, 'B2030', 20,1),
(43, 'B2355 Plus', 23,1),
(43, 'B1930', 19,1),
(43, 'B1931', 19,1),
(43, 'Sync Master 2233', 22,1),
(43, 'Sync Master723N', 17,1),
(43, '923NW', 19,1);
";
        DB::statement($query);
        DB::statement('update monitors set adder=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
