<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuietusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quietuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('flat_id');
            $table->unsignedInteger('tenant_id');
            $table->boolean('pay_status');
            $table->foreign('flat_id')
                    ->references('id')->on('flats')
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
        Schema::dropIfExists('quietuses');
    }
}
