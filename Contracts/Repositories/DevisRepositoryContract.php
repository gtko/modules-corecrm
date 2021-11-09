<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface DevisRepositoryContract extends SearchableRepository, RepositoryFetchable,RelationsRepositoryContract
{
    public function create(Dossier $dossier, Commercial $commercial): DevisEntities;
    public function updateData(DevisEntities $devis, array $data): DevisEntities;
    public function updateFournisseur(DevisEntities $devis, Fournisseur $fournisseur): DevisEntities;
    public function sendPriceFournisseur(DevisEntities $devis, Fournisseur $fournisseur, Carbon $mail_sended = null, bool $validate = false) :DevisEntities;
    public function detachFournisseur(DevisEntities $devis, Fournisseur $fournisseur) :bool;
    public function validateFournisseur(DevisEntities $devis, Fournisseur $fournisseur, bool $validate = true);
    public function getFournsisseurValidate(DevisEntities $devi) : Collection;
    public function getPrice(DevisEntities $devi, Fournisseur $fournisseur): float;
    public function validatedDevis(DevisEntities $devi, array $data): bool;

    public function getDevisByDossier(Dossier $dossier):LengthAwarePaginator;

    public function delete(DevisEntities $devis): bool;
}
