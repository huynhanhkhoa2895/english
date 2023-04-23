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
        Schema::create('practice_student_submit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_student_id')->constrained('practice_student')->onDelete('cascade');
            $table->string('question_title')->nullable();
            $table->string("point",15)->nullable();
            $table->string("note")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_student_submit');
    }
};
