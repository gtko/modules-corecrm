<?php

namespace Modules\CoreCRM\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Client;
use Modules\BaseCore\Models\Email;
use Modules\BaseCore\Models\Personne;
use Modules\BaseCore\Models\Phone;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientEntity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'personne_id' => Personne::factory()
                ->hasAttached(Phone::factory()->create())
                ->hasAttached(Email::factory()->create()),
        ];
    }
}
