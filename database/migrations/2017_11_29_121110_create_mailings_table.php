<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mailinglist_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->string('layout');
            $table->string('subject');
            $table->text('text');
            $table->datetime('sent_at')->nullable()->default(null);
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
        Schema::drop('mailings');
    }
}
