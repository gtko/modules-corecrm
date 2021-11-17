<?php

namespace Modules\CoreCRM\Actions\Clients;

use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;

class CreateDossierIfWithoutOpen
{

    public function open(ClientEntity $client,Commercial $commercial, Source $source, Status $status):Dossier
    {

        $repDossier = app(DossierRepositoryContract::class);

        $dossiers = $repDossier->getDossierByClientAndStatus($client, $status);

        if($dossiers->count() > 0){
            return $dossiers->first();
        }

        return $repDossier->create($client, $commercial, $source, $status);
    }

}
