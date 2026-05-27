<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            // Kita pakai kondisi agar tidak error jika kolom sudah ada
            if (!Schema::hasColumn('warehouses', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('warehouses', 'lat')) {
                $table->string('lat')->nullable();
            }
            if (!Schema::hasColumn('warehouses', 'lng')) {
                $table->string('lng')->nullable();
            }
            if (!Schema::hasColumn('warehouses', 'capacity')) {
                $table->integer('capacity')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn(['location', 'lat', 'lng', 'capacity']);
        });
    }
};
