<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultValueToOrganizationsDealsMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('organizations_deals_members', function (Blueprint $table) {
            $table->boolean('is_readed_owner_response')->default(0)->change();
            $table->boolean('is_readed_owner_deal')->default(0)->change();
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
            //
        });
    }
}
