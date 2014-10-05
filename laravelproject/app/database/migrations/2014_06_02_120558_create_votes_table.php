<?php

/**
 * Create this file:
 * php artisan migrate:make create_votes_table --create=votes
 * 
 * Run the migrations:
 * php artisan migrate  
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('votes', function(Blueprint $table) {
            $table->increments('vote_id');
            $table->integer('user_id');
            $table->integer('auction_id');
            $table->integer('date_created');    //timestamp
            $table->integer('stars')->default(0);
            /*
             * Unique by 2 fields
             */
            $table->unique(array('user_id', 'auction_id'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('votes');
    }

}
