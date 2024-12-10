<?php

use App\Models\QualifySupport;
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
        Schema::create((new QualifySupport)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('qualification', unsigned: true)->default(1)->comment('Del 1 al 5, 1 es peor y 5 es mejor');
            $table->text('comment')->nullable();
            $table->foreignIdFor(Ticket::class)->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new QualifySupport)->getTable());
    }
};
