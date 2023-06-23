<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\Admin\UsersController;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new App\Models\User();
        $user->name = 'admin';
        $user->password = Hash::make('admin');
        $user->email = 'admin@admin.com';
        $user->role = \App\Models\User::ROLE_ADMINISTRATOR;
        $user->status = \App\Models\User::USER_STATUS_APPROVE;
        $user->unique_id = \App\Models\User::generateUniqueUserIdNumber();
        $user->privilege_id = 1;
        
        $user->save();

    }
}
