<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
/**
 * to create this file:
 * php artisan migrate:make create_user_table --create=user
 * 
 * to run the migrations:  php artisan migrate
 */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->engine = "InnoDB";
            
            $table->increments('user_id');

            $table->string('name', 32);
            $table->string('username', 32);
            $table->string('email', 250);
            $table->string('password', 64);
            
            $table->string('remember_token', 250);
            
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
        Schema::drop('users');
    }

}
