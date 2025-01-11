<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key for the reviewer
            $table->string('user_name'); // Foreign key for the reviewer
            $table->unsignedBigInteger('seller_id'); // Foreign key for the seller
            $table->unsignedBigInteger('item_id'); // Foreign key for the item being reviewed
            $table->unsignedInteger('rating'); // Rating percentage (e.g., 80 for 80%)
            $table->text('content'); // Review content
            $table->unsignedInteger('helpful_count')->default(0); // Helpful count
            $table->unsignedInteger('unhelpful_count')->default(0); // Unhelpful count
            $table->timestamps(); // Created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
