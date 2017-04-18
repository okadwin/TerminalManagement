<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('AgentName');//代理商名称
            $table->string('Person');//法人
            $table->string('cPerson');//联系人
            $table->string('cPhone');//联系电话
            $table->string('IDcard');//身份证号
            $table->string('BankAccountNum');//账户号/银行卡号
            $table->string('BankAccountName');//账户名/银行开户名
            $table->string('BankName');//开户行
            $table->string('BankNum');//联行号
            $table->string('Profit');//分润费率
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
        Schema::dropIfExists('agents');
    }
}
