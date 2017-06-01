<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('member_id')->unsigned()->index();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->string('name');
            $table->string('additional')->nullable();
            $table->string('street');
            $table->string('zipcode', 20);
            $table->string('city');
            $table->integer('country_id')->unsigned()->index();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->timestamps();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->boolean('address_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addresses');

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('address_id');
        });
    }
}
