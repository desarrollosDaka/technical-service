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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ItemCode')->nullable();
            $table->string('ItemName')->nullable();
            $table->string('CodeBars')->nullable();
            $table->integer('U_DK_GARANTIA')->nullable();
            $table->string('U_FAMILIA')->nullable();
            $table->string('ItmsGrpNam')->nullable();
            $table->string('in_mobile_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
