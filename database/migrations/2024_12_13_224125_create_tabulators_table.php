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
        Schema::create('tabulators', function (Blueprint $table) {
            $table->id();
            $table->string('n')->nullable();
            $table->string('linea')->nullable();
            $table->string('gama')->nullable();
            $table->string('product')->nullable();
            $table->string('familia')->nullable();
            $table->string('repuestos')->nullable();
            $table->string('costos_servicios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabulators');
    }
};
