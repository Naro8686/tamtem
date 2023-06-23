<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRowsReferalUrlAndPointsFromAgentsAndFromAgentToUsersTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('referal_url')->after('ballance')->description('Реферальная ссылка на себя');
            $table->unsignedInteger('from_agent')->after('referal_url')->nullable()->description('По чьей рефералке зарегистрировался');
            $table->integer('points_from_agents')->after('points')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('referal_url');
            Schema::dropIfExists('from_agent');
            Schema::dropIfExists('points_from_agents');
        });
    }
}
