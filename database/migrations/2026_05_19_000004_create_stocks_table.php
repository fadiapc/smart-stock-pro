<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->string('location')->default('Gudang Utama');
            $table->timestamps();
            $table->index(['product_id', 'location']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
