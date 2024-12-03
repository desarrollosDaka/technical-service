<?php

use App\Models\TechnicalVisit;
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
        Schema::create((new TechnicalVisit)->getTable(), function (Blueprint $table) {
            $table->comment('La taba de visitas, sera la que se usara para formar el campo ServiceCall:resolution');
            $table->id();
            $table->foreignIdFor(\App\Models\Ticket::class)->constrained()->cascadeOnDelete();
            $table->timestamp('visit_date')->nullable();
            $table->text('observations')->nullable()->comment('Recordar poder adjuntar imágenes (max: 5)');
            $table->json('meta')->nullable()->comment('Dentro del meta puede ir información adicional en un estilo dinámico');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new TechnicalVisit)->getTable());
    }
};
