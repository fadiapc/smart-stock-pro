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
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->string('user_name')->nullable(); // Siapa yang melakukan
        $table->string('action'); // Apa yang diakses/dilakukan
        $table->string('ip_address')->nullable(); // Dari IP mana
        $table->timestamps(); // Kapan waktunya
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
