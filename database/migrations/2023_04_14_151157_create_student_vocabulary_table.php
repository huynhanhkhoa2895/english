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
        Schema::create('student_vocabulary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student')->onDelete('cascade');
            $table->foreignId('vocabulary_id')->constrained('vocabulary')->onDelete('cascade');
            $table->float("point")->default(5);
            $table->integer("repeat")->default(0);
            $table->boolean('new')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_vocabulary');
    }
};
