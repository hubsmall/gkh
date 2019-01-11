<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuietusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quietus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('flat_id');
            $table->boolean('pay_status');
            $table->foreign('flat_id')
                    ->references('id')->on('flats')
                    ->onDelete('cascade');           
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
        Schema::dropIfExists('quietus');
    }
}
