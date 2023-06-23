<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('order_id', 50)->nullable();
            $table->double('amount', 10, 2)->default(0);
            $table->integer('payment_system');
            $table->string('payment_to');
            $table->integer('status')->default(0);
            $table->text('text');
            $table->text('request');
            $table->text('result');
            $table->text('decode_result');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_operations');
    }
}
