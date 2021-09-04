<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      $admin =  Role::updateOrCreate([
            'name' => 'admin',
        ],
            [
                'guard_name' => 'web'
            ]
        );

        $admin->givePermissionTo('salons.index');
        $admin->givePermissionTo('salons.show');
        $admin->givePermissionTo('salons.create');
        $admin->givePermissionTo('salons.store');
        $admin->givePermissionTo('salons.update');
        $admin->givePermissionTo('salons.destroy');
        $admin->givePermissionTo('salons.edit');
        $admin->givePermissionTo('salons.show.months');

        $admin->givePermissionTo('users.index');
        $admin->givePermissionTo('users.create');
        $admin->givePermissionTo('users.store');
        $admin->givePermissionTo('users.update');
        $admin->givePermissionTo('users.destroy');
        $admin->givePermissionTo('users.edit');

        $admin->givePermissionTo('reports.index');
        $admin->givePermissionTo('reports.create');
        $admin->givePermissionTo('reports.store');
        $admin->givePermissionTo('reports.update');
        $admin->givePermissionTo('reports.destroy');
        $admin->givePermissionTo('reports.edit');

        $admin->givePermissionTo('sources.index');
        $admin->givePermissionTo('sources.create');
        $admin->givePermissionTo('sources.store');
        $admin->givePermissionTo('sources.update');
        $admin->givePermissionTo('sources.destroy');
        $admin->givePermissionTo('sources.edit');
        $admin->givePermissionTo('can.update.fix');

        $admin->givePermissionTo('expenses.index');
        $admin->givePermissionTo('expenses.create');
        $admin->givePermissionTo('expenses.edit');
        $admin->givePermissionTo('expenses.store');
        $admin->givePermissionTo('expenses.update');
        $admin->givePermissionTo('expenses.destroy');

        $admin->givePermissionTo('contractors.index');
        $admin->givePermissionTo('contractors.create');
        $admin->givePermissionTo('contractors.edit');
        $admin->givePermissionTo('contractors.store');
        $admin->givePermissionTo('contractors.update');
        $admin->givePermissionTo('contractors.destroy');

        $admin->givePermissionTo('expensesTypes.index');
        $admin->givePermissionTo('expensesTypes.create');
        $admin->givePermissionTo('expensesTypes.edit');
        $admin->givePermissionTo('expensesTypes.store');
        $admin->givePermissionTo('expensesTypes.update');
        $admin->givePermissionTo('expensesTypes.destroy');

       $salon_admin = Role::updateOrCreate([
            'name' => 'salon_admin',
        ],
            [
                'guard_name' => 'web'
            ]
        );

        $salon_admin->givePermissionTo('salons.index');
        $salon_admin->givePermissionTo('salons.show');

        $salon_admin->givePermissionTo('reports.index');
        $salon_admin->givePermissionTo('reports.create');
        $salon_admin->givePermissionTo('reports.edit');
        $salon_admin->givePermissionTo('reports.update');
        $salon_admin->givePermissionTo('reports.store');
    }
}
