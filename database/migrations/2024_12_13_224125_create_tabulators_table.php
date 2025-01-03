<?php

use App\Models\Tabulator;
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
        Schema::create((new Tabulator)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('n')->unique();
            $table->string('linea')->nullable();
            $table->string('gama')->nullable();
            $table->string('producto')->nullable();
            $table->string('familia')->nullable();
            $table->string('repuestos')->nullable();
            $table->string('costos_servicios')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Tabulator)->getTable());
    }
};
