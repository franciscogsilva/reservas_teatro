<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('row');
            $table->integer('column');

            $table->integer('reservation_id')->unsigned()->nullable();
            $table->foreign('reservation_id')->references('id')->on('reservations');

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
        Schema::dropIfExists('chairs');
    }
}
