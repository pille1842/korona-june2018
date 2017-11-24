<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('slug');
            $table->string('nickname');
            $table->string('firstname');
            $table->string('lastname');
            $table->boolean('inverse_name_order')->default(false);
            $table->string('birthname');
            $table->enum('sex', ['MALE', 'FEMALE']);
            $table->string('title');
            $table->string('profession');
            $table->string('status');
            $table->date('birthday');
            $table->boolean('active');
            $table->integer('profile_picture')->unsigned()->nullable();
            $table->foreign('profile_picture')->references('id')->on('images');
            $table->boolean('address_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('members');
    }
}
