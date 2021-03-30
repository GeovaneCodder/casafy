<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "address" => $this->faker->address,
            "bedrooms" => $this->faker->numberBetween(1, 10),
            "bathrooms" => $this->faker->numberBetween(1, 5),
            "total_area" => $this->faker->numberBetween(60, 300),
            "purchased" => $this->faker->boolean,
            "value" => $this->faker->numberBetween(10000),
            "discount" => $this->faker->numberBetween(5, 70),
            "owner_id" => User::factory(),
            "expired" => $this->faker->boolean,
        ];
    }
}
