<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ShopAgent');
            $table->string('ShopNumber');
            $table->string('ShopName');
            $table->string('ShopContact');
            $table->string('ShopContactID');
            $table->string('ShopContactPhone');
            $table->integer('ShopJoinTime');
            $table->integer('ShopStatus');
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
        Schema::dropIfExists('shops');
    }
}
