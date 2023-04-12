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
        Schema::create('practice_question_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('practice_question')->cascadeOnDelete();
            $table->string('question');
            $table->string('answer')->nullable();
            $table->string('values')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_question_content');
    }
};
