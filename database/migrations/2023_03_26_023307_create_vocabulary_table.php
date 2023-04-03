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
        Schema::create('vocabulary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('category');
            $table->string("vocabulary")->unique();
            $table->string("parts_of_speech",20)->nullable()->index();
            $table->string("translate")->nullable();
            $table->string("spelling")->nullable();
            $table->text("example")->nullable();
            $table->string("sound")->nullable();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabulary');
    }
};
