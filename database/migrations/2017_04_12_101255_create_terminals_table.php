<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Type');
            $table->string('SN');
            $table->string('Location');
            $table->string('InTime');
            $table->string('InUser');
            $table->string('ShopNumber')->nullable();
            $table->string('TerminalNumber')->nullable();
            $table->string('Channel')->nullable();
            $table->integer('OutType')->nullable();
            $table->string('OutTime')->nullable();
            $table->string('OutUser')->nullable();
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
        Schema::dropIfExists('terminals');
    }
}
