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
        Schema::create('practice', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("level",2)->index();
            $table->string("type",10)->index();
            $table->string("instructions")->nullable();
            $table->text("content");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice');
    }
};
