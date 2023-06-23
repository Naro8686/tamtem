<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogStatisticRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_statistic_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url')->comment('адрес, куда слали запрос');
            $table->longText('post_data')->comment('что послали');
            $table->longText('return_data')->nullable()->comment('что пришло');
            $table->tinyInteger('result')->default(false);
            $table->integer('status')->default(200);
            $table->timestamp('request_date')->nullable()->comment('время запроса');
            $table->string('text')->comment('какое -то описание');
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
        Schema::dropIfExists('log_statistic_requests');
    }
}
