<?php

use App\Enums\Ticket\Status as TicketStatus;
use App\Models\Ticket;
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
        Schema::create((new Ticket)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technical_id')->comment('Se relaciona con technicals:ID_user');
            $table->unsignedBigInteger('service_call_id')->comment('Se relaciona con service_calls:callID');
            $table->string('title');
            $table->timestamp('diagnosis_date')->nullable()->comment('Fecha en el que el técnico realizo el diagnostico');
            $table->text('diagnosis_detail')->nullable()->comment('Los detalles del diagnostico, acordar subir también imágenes (max: 5)');
            $table->timestamp('solution_date')->nullable()->comment('Fecha en el que el técnico realizo la solución, o finaliza el ticket');
            $table->text('solution_detail')->nullable()->comment('Los detalles de la solución, acordar subir también imágenes (max: 5)');
            // Nombre del articulo (ItemName)
            // ID del articulo (itemCode)
            $table->string('customer_name')->nullable();
            $table->tinyInteger('status', unsigned: true)->default(TicketStatus::class);
            $table->float('total_cost')->nullable();
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Ticket)->getTable());
    }
};
