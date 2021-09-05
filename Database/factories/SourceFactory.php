<?php

namespace Modules\CoreCRM\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CoreCRM\Models\Source;

class SourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Source::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->unique()->word,
        ];
    }
}
