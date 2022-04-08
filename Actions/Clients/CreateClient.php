<?php

namespace Modules\CoreCRM\Actions\Clients;

use Illuminate\Http\Request;
use Modules\BaseCore\Actions\Personne\PersonneAddEmail;
use Modules\BaseCore\Actions\Personne\PersonneAddPhone;
use Modules\BaseCore\Contracts\Personnes\CreatePersonneContract;
use Modules\BaseCore\Http\Requests\PersonneStoreRequest;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;

class CreateClient
{


    public function create(Request $request, Commercial $commercial, Source $source, Status $status): Dossier
    {
        $repDossier = app(DossierRepositoryContract::class);

        foreach ($request->email as $strEmail) {
            if($strEmail) {
                $dossiersByEmail = $repDossier->getByEmail($strEmail);
                foreach ($request->phone as $strPhone) {
                    if ($strPhone) {
                        $dossierByphone = $repDossier->getByPhone($strPhone);
                    } else {
                        $dossierByphone = collect([]);
                    }
                    if ($dossiersByEmail->count() > 0 && $dossierByphone->count() > 0) {
                        if ($dossiersByEmail->first()->clients_id === $dossierByphone->first()->clients_id) {
                            //on créer un nouveau dossier au client si aucun dossier n'est déja ouvert
                            return (new CreateDossierIfWithoutOpen())->open($dossiersByEmail->first()->client, $commercial, $source, $status);
                        } else {
                            //erreur fatal
                            abort(500, "L'email fournit et le téléphone appartienne à deux clients différent.
                        Situation impossible. Veuillez contacter l'administrateur du CRM");
                        }
                    } elseif ($dossiersByEmail->count() > 0 && $dossierByphone->count() === 0) {
                        //on rajoute l'email à la personne
                        $personne = $dossiersByEmail->first()->client->personne;
                        $phones = $personne->phones->pluck('phone')->toArray();
                        $phones[] = $strPhone;
                        (new PersonneAddPhone())->add($phones, $personne);
                        //on créer un nouveau dossier au client si aucun dossier n'est déja ouvert
                        return (new CreateDossierIfWithoutOpen())->open($dossiersByEmail->first()->client, $commercial, $source, $status);
                    } elseif ($dossiersByEmail->count() === 0 && $dossierByphone->count() > 0) {
                        //on rajoute le phone à la personne
                        $personne = $dossierByphone->first()->client->personne;
                        $emails = $personne->emails->pluck('email')->toArray();
                        $emails[] = $strEmail;
                        (new PersonneAddEmail())->add($emails, $personne);
                        //on créer un nouveau dossier au client si aucun dossier n'est déja ouvert
                        return (new CreateDossierIfWithoutOpen())->open($dossierByphone->first()->client, $commercial, $source, $status);
                    }
                }
            }
        }

        //on créer une nouvelle personne et un nouveau client avec un dossier vierge
        $personneRequest = new PersonneStoreRequest();
        $personneRequest->replace($request->all());
        $personne = app(CreatePersonneContract::class)->create($personneRequest);
        return (new CreateClientWithDossier())->create($personne, $commercial, $source, $status);
    }

}
