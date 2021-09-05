<?php

namespace Modules\CoreCRM\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CoreCRM\Models\Status;

class StatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Status::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->unique()->word,
            'weight' => $this->faker->randomNumber(0),
        ];
    }
}
