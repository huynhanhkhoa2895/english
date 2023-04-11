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
        Schema::create('result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained('student')->cascadeOnDelete();
            $table->unsignedBigInteger("question_id")->index();
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
        Schema::dropIfExists('result');
    }
};
