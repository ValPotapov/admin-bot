<?php

namespace Database\Seeders;

use App\Models\ModelHasRole;
use App\Models\Report;
use App\Models\Salon;
use App\Models\User;
use Database\Factories\ModelHasRoleFactory;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Salon::factory()->count(20)->create();
        Report::factory()->count(500)->create();
        User::factory()->count(8)->create();
        ModelHasRole::factory()->count(8)->create();
    }
}
