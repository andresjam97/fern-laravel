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
        Schema::create('order_heads', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->string('estado')->nullable();
            $table->string('fecha_requerida')->nullable();
            $table->unsignedBigInteger('id_colegio');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_heads');
    }
};
