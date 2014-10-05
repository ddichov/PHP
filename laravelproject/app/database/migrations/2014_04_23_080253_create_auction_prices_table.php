<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionPricesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auction_prices', function(Blueprint $table) {
            $table->increments('price_id');

            $table->integer('auction_id');
            $table->integer('user_id');
            $table->decimal('price', 8, 2);
            $table->integer('date_created');    //timestamp
            
             /**
             * To add a deleted_at column to your table
             */
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('auction_prices');
    }

}
