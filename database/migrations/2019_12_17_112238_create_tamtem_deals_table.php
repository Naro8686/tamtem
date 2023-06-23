<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTamtemDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamtem_deals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tamtem_organization_okved');
            $table->string('name');
            $table->string('type_deal', 10)->default('buy');
            $table->string('category')->default('');
            $table->string('region', 64)->default('Брянская область');
            $table->double('budget_from', 14, 2)->default(0);
            $table->double('budget_to', 14, 2)->default(0);
            $table->double('budget_all', 14, 2)->default(0);
            $table->string('unit_for_unit')->default('');
            $table->string('unit_for_all')->default('');
            $table->integer('val_for_all')->default(1);
            $table->date('deadline_deal')->nullable();    
            $table->timestamp('published_at')->nullable();   
            $table->string('dqh_volume', 255)->default('');
            $table->string('dqh_specification', 2048)->default('');
            $table->string('dqh_doc_confirm_quality', 255)->default('');
            $table->string('dqh_logistics', 255)->default('');
            $table->string('dqh_type_deal', 255)->default('');
            $table->string('dqh_payment_term', 255)->default('');
            $table->string('dqh_payment_method', 255)->default('');
            $table->string('dqh_min_party', 255)->default('');
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
        Schema::dropIfExists('tamtem_deals');
    }
}
