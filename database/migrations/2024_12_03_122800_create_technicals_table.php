<?php

use App\Models\Technical;
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
        Schema::create((new Technical)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('ID_user');
            $table->string('Name_user_comercial')->nullable();
            $table->string('Services')->nullable();
            $table->string('User_name')->nullable();
            $table->string('Email')->nullable();
            $table->string('Password')->nullable();
            $table->string('Identification_Comercial')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Address')->nullable();
            $table->integer('Tickets', unsigned: true)->nullable()->comment('Esto es la cantidad de tickets abierto que tiene el usuario');
            $table->integer('Tickets_rejected', unsigned: true)->nullable()->comment('Total de tickets rechazados');
            $table->integer('Qualification')->nullable()->comment('Media de la calificación de los tickets');
            $table->string('Agency')->nullable();
            $table->bigInteger('ID_rol')->nullable();
            $table->string('ID_supplier')->nullable();
            $table->integer('Availability')->nullable();
            $table->json('GeographicalCoordinates')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('Create_user')->nullable();
            $table->dateTime('Create_date')->nullable();
            $table->integer('Update_user')->nullable();
            $table->dateTime('Update_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Technical)->getTable());
    }
};
