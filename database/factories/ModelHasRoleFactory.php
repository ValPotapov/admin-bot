<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelHasRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModelHasRole::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'model_type' => 'App\Models\User',
            'role_id' => 2,
            'model_id' => $this->faker->unique(true)->numberBetween(2, 10)
        ];
    }
}
