<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'salon_id' => Salon::all()->random(),
            'phone' => $this->faker->phoneNumber,
            'number_calls' => rand(0,100),
            'came' => rand(0,100),
            'stayed' => rand(0,100),
            'created_at' => $this->faker->dateTimeBetween('01.01.2021', 'now')
        ];
    }
}
