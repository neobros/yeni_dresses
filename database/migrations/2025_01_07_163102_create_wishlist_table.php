<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_ID'); // Reference to customer_seller table
            $table->unsignedBigInteger('item_ID'); // Reference to the items
            $table->timestamps();

            // Foreign key constraint to ensure data integrity
            $table->foreign('user_ID')
                ->references('id')
                ->on('customer_seller')
                ->onDelete('cascade'); // Deletes wishlist entries when the user is deleted

            // You can also add a foreign key constraint for the item_ID if you have an items table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlist');
    }
}
