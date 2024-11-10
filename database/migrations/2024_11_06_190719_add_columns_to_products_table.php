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
        Schema::table('products', function (Blueprint $table) {
            $table->string('length', 45)->nullable();
            $table->string('width', 45)->nullable();
            $table->string('depth', 45)->nullable();
            $table->string('sitting_height', 45)->nullable();
            $table->boolean('hard_eyes')->default(true);
            $table->string('main_material', 500)->nullable();
            $table->string('inner_filling_material', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('length');
            $table->dropColumn('width');
            $table->dropColumn('depth');
            $table->dropColumn('sitting_height');
            $table->dropColumn('hard_eyes');
            $table->dropColumn('main_material');
            $table->dropColumn('inner_filling_material');
        });
    }
};
