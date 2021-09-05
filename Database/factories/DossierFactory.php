<?php

namespace Modules\CoreCRM\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\BaseCore\Models\User;

class DossierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dossier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_start' => $this->faker->dateTime,
            'clients_id' => Client::factory(),
            'source_id' => Source::factory(),
            'status_id' => Status::factory(),
            'commercial_id' => User::factory(),
        ];
    }
}
