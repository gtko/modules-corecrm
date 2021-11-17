<?php

namespace Modules\CoreCRM\Actions\Clients;

use Illuminate\Http\Request;
use Modules\BaseCore\Contracts\Personnes\CreatePersonneContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;

class CreateClient
{


    public function create(Request $request, Commercial $commercial, Source $source, Status $status): Dossier
    {
        $repDossier = (app(DossierRepositoryContract::class));


        foreach ($request->email as $strEmail) {

            $dossiersByEmail = $repDossier->getByEmail($strEmail);

            foreach ($request->phone as $strPhone) {

                $dossierByphone = $repDossier->getByPhone($strPhone);

                if ($dossiersByEmail->count() > 0 && $dossierByphone->count() > 0) {
                    dump("dossier avec le meme mail et tel");
                } elseif ($dossiersByEmail->count() > 0 && $dossierByphone->count() === 0) {
                    dump("dossier avec le meme mail");
                } elseif ($dossiersByEmail->count() === 0 && $dossierByphone->count() > 0) {
                    dump("dossier avec le meme tel");
                } else {
//                    dump("Mail et tel unique");
                }

            }
        }

        $personne = app(CreatePersonneContract::class)->create($request);

        $client = (new CreateClientWithDossier())->create($personne, $commercial, $source, $status);

        return $client;
    }

}
