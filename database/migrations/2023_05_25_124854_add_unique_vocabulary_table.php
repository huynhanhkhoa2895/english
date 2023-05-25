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
        //
        Schema::table('vocabulary', function (Blueprint $table) {
            $table->dropUnique('vocabulary_vocabulary_unique');
            $table->unique(['vocabulary','parts_of_speech']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practice', function (Blueprint $table) {
            $table->dropUnique(['vocabulary','parts_of_speech']);
            $table->unique('vocabulary');
        });
    }
};
