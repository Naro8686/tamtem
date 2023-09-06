<?php

use Illuminate\Database\Seeder;

class AdminsPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $permissions = config('b2b.permissions');
      $newPermissions = [];

      foreach ($permissions as $category) {
        $slug = $category['slug'];
        foreach ($category['permissions'] as $permission) {
          $newPermissions[] = $slug . '.' . $permission;
        }
      }


        $admins = \App\Models\User::query()->where(['role' => \App\Models\User::ROLE_ADMINISTRATOR])->get();
        if (count($admins)) {
          foreach ($admins as $admin) {
            $admin->syncPermissions($newPermissions);
          }
        }
    }
}
