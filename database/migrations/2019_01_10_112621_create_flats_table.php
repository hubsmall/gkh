<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->unsignedInteger('block_id');
            $table->unsignedInteger('tenant_id');
            $table->foreign('block_id')
                    ->references('id')->on('blocks')
                    ->onDelete('cascade');          
            $table->foreign('tenant_id')
                    ->references('id')->on('tenants')
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
        Schema::dropIfExists('flats');
    }
}
