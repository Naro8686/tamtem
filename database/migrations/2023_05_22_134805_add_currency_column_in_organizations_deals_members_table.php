<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyColumnInOrganizationsDealsMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations_deals_members', function (Blueprint $table) {
           $table->string('price_currency')->default('rur')->after('price_offer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations_deals_members', function (Blueprint $table) {
            $table->dropColumn(['price_currency']);
        });
    }
}
