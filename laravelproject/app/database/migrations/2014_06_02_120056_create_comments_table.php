<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
                    $table->increments('comment_id');
                    $table->integer('user_id');
                    $table->integer('auction_id');
                    $table->integer('date_created'); //timestamp
                    $table->string('comment_title', 32);
                    $table->string('comment_text', 320);

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
	public function down()
	{
		Schema::drop('comments');
	}

}
