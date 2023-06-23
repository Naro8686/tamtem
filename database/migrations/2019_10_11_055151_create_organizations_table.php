<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('inn', 12)->index();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(\App\Models\Organization::ORGANIZATION_STATUS_UNACTIVATED);
            $table->text('referal_url');
            $table->text('category_name')->nullable();
            $table->integer('points_buy_bid')->default(0)->comment('баллы за заявку о куплю');
            $table->integer('points_set_winner')->default(0)->comment('баллы за количество выбранных победителей');
            $table->integer('points_response')->default(0)->comment('баллы за отклик');
            $table->double('response_ballance', 10, 2)->default(0)->comment('сумма всех списаний за покупку контактов клиентом');
            $table->timestamp('activated_at')->nullable()->comment('дата активации организации клиентом по рефссылке');
            $table->timestamp('before_to_at')->nullable()->comment('до какого времени будет действовать прикрепление организации');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
