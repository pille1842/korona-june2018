<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonenumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phonenumbers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('phoneable_type');
            $table->integer('phoneable_id')->unsigned();
            $table->enum('type', ['WORK', 'HOME', 'FAX', 'WORK_MOBILE', 'HOME_MOBILE', 'FAX_WORK', 'OTHER', 'OTHER_MOBILE']);
            $table->string('phonenumber');
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::drop('phonenumbers');
    }
}
