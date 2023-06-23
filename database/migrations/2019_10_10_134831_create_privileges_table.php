<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('бронзовый, золотой и т.п.');
            $table->integer('point')->default(0)->comment('до каких баллов, включительно, будет именно такой процент и привилегия');
            $table->tinyInteger('duration_months')->nullable()->comment('Продолжительность действия привилегии в месяцах');
            $table->double('procent', 10, 5)->default(0);    
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed', array('--class' => 'PrivilegesSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privileges');
    }
}
