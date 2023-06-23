<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhonePhotoBallancePriviligePointsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 11)->after('role')->nullable()->comment('Телефон пользователя');
            $table->string('photo',  255)->after('phone')->nullable()->comment('Аватарка пользователя');
            $table->unsignedInteger('privilege_id')->after('photo')->nullable();
            $table->integer('points')->after('privilege_id')->default(0);
            $table->double('ballance', 10, 2)->after('points')->default(0);
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
            $table->dropColumn('phone');
            $table->dropColumn('photo');
            $table->dropColumn('privilege_id');
            $table->dropColumn('points');
            $table->dropColumn('ballance');
        });
    }
}
