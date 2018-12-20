<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvantagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advantages', function (Blueprint $table) {
            $table->increments('id');
            $table->float('percent');
            $table->unsignedInteger('serve_id');
            $table->unsignedInteger('tenant_id');
            $table->foreign('serve_id')
                    ->references('id')->on('serves')
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
        Schema::dropIfExists('advantages');
    }
}
