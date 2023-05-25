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
        Schema::create('vocabulary_relationship', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_main')->constrained('vocabulary')->onDelete('cascade');
            $table->foreignId('vocabulary_relationship')->constrained('vocabulary')->onDelete('cascade');
            $table->enum("relationship",['word-form','synonyms','antonyms'])->default('word-form');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabulary_relationship');
    }
};
