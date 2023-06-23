<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBudgetWithNDSAndDateOfEvenrToTamtemDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tamtem_deals', function (Blueprint $table) {
            $table->boolean('budget_with_nds')->after('budget_all')->default(false)->comment('указанный бюджет с НДС или нет');
            $table->string('date_of_event')->after('deadline_deal')->default('')->comment('дата проведения сделки, тут строка в свободной форме');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tamtem_deals', function (Blueprint $table) {
            Schema::dropIfExists('budget_with_nds');
            Schema::dropIfExists('date_of_event');
        });
    }
}
