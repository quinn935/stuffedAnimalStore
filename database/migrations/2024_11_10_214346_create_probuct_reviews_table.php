<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('probuct_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
            ->constrained('products')  // This automatically links to the `id` column in the `products` table
            ->onDelete('cascade')      // Deletes the review if the related product is deleted
            ->onUpdate('cascade');
            $table->integer('rating');
            $table->string('review_subject')->nullable();
            $table->longText('review_comment')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('probuct_reviews');
    }
};
