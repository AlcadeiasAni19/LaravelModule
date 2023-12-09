<?php

namespace Modules\Carts\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Carts\app\Models\Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "order_code" => $this->faker->regexify('[A-Za-z0-9]{6}')
        ];
    }
}

