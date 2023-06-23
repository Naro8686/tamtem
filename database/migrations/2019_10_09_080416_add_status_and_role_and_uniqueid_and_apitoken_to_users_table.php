<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\User;

class AddStatusAndRoleAndUniqueidAndApitokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('unique_id')->after('password')->unique();
            $table->tinyInteger('status')->after('unique_id')->default(User::USER_STATUS_REGISTRED);
            $table->tinyInteger('role')->after('status')->default(User::ROLE_CLIENT);
            $table->string('api_token', 60)->after('role')->unique()->nullable()->default(null);
            $table->string('register_confirm_token', 60)->after('api_token')->unique()->nullable()->default(null);
            $table->string('reset_password_token')->after('register_confirm_token')->unique()->nullable();
            $table->softDeletes();
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
            Schema::dropIfExists('unique_id');
            Schema::dropIfExists('status');
            Schema::dropIfExists('role');
            Schema::dropIfExists('api_token');
            Schema::dropIfExists('register_confirm_token');
            Schema::dropIfExists('reset_password_token');
            Schema::dropIfExists('deleted_at');
        });
    }
}
