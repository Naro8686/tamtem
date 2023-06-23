<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointPerEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_per_event', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_name', 191)->index()->unique()->comment('напр. bid_buy - размещение предложения по покупке');
            $table->integer('point')->default(1)->comment('кол-во баллов');
            $table->timestamps();
            $table->softDeletes();
        });

        // Artisan::call('db:seed', array('--class' => 'PointPerEventSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_per_event');
    }
}
