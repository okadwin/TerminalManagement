<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('TransactionTime');
            $table->string('ShopNumber');
            $table->string('TerminalNumber');
            $table->string('TransactionName');
            $table->string('SettleName');
            $table->string('SettleAmount');
            $table->string('BankAccountNumber');
            $table->string('TransactionAmount');
            $table->string('Fee');
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
        Schema::dropIfExists('transactions');
    }
}
