<?php

use App\Models\Comment;
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
        Schema::create((new Comment)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->string('commentator_type')->nullable()->comment('Si esta vació se esta asumiendo que lo hizo el usuario.');
            $table->unsignedBigInteger('commentator_id')->nullable()->comment('Apuntaría al id del técnico, MASTER_TECHNICIAN:ID_user');
            $table->text('comment');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Comment)->getTable());
    }
};
