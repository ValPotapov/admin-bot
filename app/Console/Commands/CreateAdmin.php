<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = Role::updateOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

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

        $user = User::updateOrCreate(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ],
            [
                'password' => Hash::make('Passw0rd'),
            ]
        );

        $user->assignRole('admin');
        return 0;
    }
}
