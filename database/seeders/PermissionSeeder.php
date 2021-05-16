<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Permission::updateOrCreate([
            'name' => 'salons.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'salons.show',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'salons.create',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'salons.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'salons.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'salons.destroy',
            'guard_name' => 'web'
        ]);

        Permission::updateOrCreate([
            'name' => 'salons.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'salons.show.months',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'users.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'users.create',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'users.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'users.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'users.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'users.destroy',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'reports.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'reports.create',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'reports.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'reports.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'reports.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'reports.destroy',
            'guard_name' => 'web'
        ]);
    }
}
