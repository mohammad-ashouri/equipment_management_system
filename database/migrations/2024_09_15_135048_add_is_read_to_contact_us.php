<?php

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
        Schema::connection('contact_us_connection')->table('contact_us', function (Blueprint $table) {
            $table->addColumn('boolean', 'is_read')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('contact_us_connection')->table('contact_us', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
};
