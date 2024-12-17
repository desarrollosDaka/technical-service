<?php

use App\Enums\PartRequest\Status as PartRequestStatus;
use App\Models\PartRequest;
use App\Models\Tabulator;
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
        Schema::create((new PartRequest)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(PartRequestStatus::New->value);
            $table->foreignIdFor(TechnicalVisit::class)->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->text('observation')->nullable();
            $table->dateTime('date_handed')->nullable()->comment('Fecha de entrega del repuesto');
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
        Schema::dropIfExists((new PartRequest)->getTable());
    }
};
