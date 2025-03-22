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
        Schema::create('lesson_listening', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lesson')->onDelete('cascade');
            $table->foreignId('lesson_listening_id')->constrained('listening')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_listening');
    }
};
