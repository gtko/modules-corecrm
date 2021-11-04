<?php

namespace Modules\CoreCRM\Actions\Clients;

use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;

class CreateClientWithDossier
{


    public function create(Personne $personne, Commercial $commercial, Source $source, Status $status):Dossier
    {
        $repClient = app(ClientRepositoryContract::class);
        $repDossier = app(DossierRepositoryContract::class);

        $client = $repClient->createClient($personne);
        return $repDossier->create($client, $commercial, $source, $status);
    }

}
