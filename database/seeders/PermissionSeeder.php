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

        Permission::updateOrCreate([
            'name' => 'sources.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'sources.create',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'sources.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'sources.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'sources.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'sources.destroy',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'can.update.fix',
            'guard_name' => 'web'
        ]);

        //expenses
        Permission::updateOrCreate([
            'name' => 'expenses.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expenses.create',
            'guard_name' => 'web'
        ]);

        Permission::updateOrCreate([
            'name' => 'expenses.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expenses.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expenses.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expenses.destroy',
            'guard_name' => 'web'
        ]);

        //expensesTypes
        Permission::updateOrCreate([
            'name' => 'expensesTypes.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expensesTypes.create',
            'guard_name' => 'web'
        ]);

        Permission::updateOrCreate([
            'name' => 'expensesTypes.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expensesTypes.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expensesTypes.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'expensesTypes.destroy',
            'guard_name' => 'web'
        ]);

        //contractors
        Permission::updateOrCreate([
            'name' => 'contractors.index',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'contractors.create',
            'guard_name' => 'web'
        ]);

        Permission::updateOrCreate([
            'name' => 'contractors.edit',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'contractors.store',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'contractors.update',
            'guard_name' => 'web'
        ]);
        Permission::updateOrCreate([
            'name' => 'contractors.destroy',
            'guard_name' => 'web'
        ]);
    }
}
