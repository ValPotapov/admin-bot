<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Salon;
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
//        Salon::factory()->count(10)->create();
        Report::factory()->count(100)->create();
    }
}
