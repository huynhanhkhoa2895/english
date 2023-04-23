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
        Schema::create('practice_student_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_student_submit_id')->constrained('practice_student_submit')->onDelete('cascade');
            $table->string("question");
            $table->string("question_type");
            $table->string("correct_answer");
            $table->string("answer")->nullable();
            $table->boolean("result");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_student_result');
    }
};
