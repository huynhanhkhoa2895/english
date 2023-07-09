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
        Schema::table('vocabulary', function (Blueprint $table) {
            $table->enum('priority',['normal','high','urgent'])->default('normal');
            $table->enum('level',['A1','A2','B1','B2','C1','C2'])->nullable();
            $table->boolean('is_phase')->default(false);
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vocabulary', function (Blueprint $table) {
            $table->dropColumn('priority');
            $table->dropColumn('level');
            $table->dropColumn('is_phase');
        });
    }
};
