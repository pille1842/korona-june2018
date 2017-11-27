<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('appellation');
            $table->boolean('inverse_name_order')->default(false);
            $table->enum('sex', ['MALE', 'FEMALE']);
            $table->string('title_prefix');
            $table->string('title_suffix');
            $table->text('notes');
            $table->integer('address_id');
            $table->integer('email_id');
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
        Schema::drop('people');
    }
}
