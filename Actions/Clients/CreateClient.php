<?php

namespace Modules\CoreCRM\Actions\Clients;

use Illuminate\Http\Request;
use Modules\BaseCore\Contracts\Personnes\CreatePersonneContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;

class CreateClient
{


    public function create(Request $request, Commercial $commercial, Source $source, Status $status):Dossier
    {
//        dd($request);

        //si email existe et pas le numero on ajoute les numero au client et on mets a jours les data

        // si tel existe mais pas email on mais a jour les data et on ajoute l'email

        $personne = app(CreatePersonneContract::class)->create($request);

        $dossier = (new CreateClientWithDossier())->create($personne, $commercial, $source, $status);
    }

}
