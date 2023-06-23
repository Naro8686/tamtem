<?php

use Illuminate\Database\Migrations\Migration;

class FillablePrivilegesAndPointPerEventTablesFromTZ extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('truncate table privileges');
        Artisan::call('db:seed', array('--class' => 'PrivilegesSeeder'));

        DB::statement('truncate table point_per_event');
        Artisan::call('db:seed', array('--class' => 'PointPerEventSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
