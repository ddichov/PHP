<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
                    $table->increments('category_id');
                    $table->integer('user_id');
                    $table->integer('parent_id')->nullable();
                   // $table->date('date_created');        //Date
                    $table->integer('date_created');        //timestamp
                    $table->string('name', 32);
                    $table->string('description', 320)->nullable();

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
		Schema::drop('categories');
	}

}
