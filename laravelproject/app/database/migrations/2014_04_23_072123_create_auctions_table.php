<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auctions', function(Blueprint $table) {
            $table->increments('auction_id');
            
            $table->integer('user_id');
            $table->string('auction_title', 32);
            $table->string('auction_desc', 320);
            $table->decimal('minimum_price', 8, 2)->default(0);
            $table->integer('date_end');        //timestamp
            $table->integer('date_created');    //timestamp
//            $table->date('date_created');       //Date
            
            $table->integer('category_id');
            $table->integer('voters')->default(0);
            /*
             * The column definition follows the format DECIMAL(M, D) 
             * where M is the maximum number of digits (the precision) 
             * and D is the number of digits to the right of the decimal point (the scale).
             */
            $table->decimal('stars', 3, 2)->default(0);
            
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
        Schema::drop('auctions');
    }

}
