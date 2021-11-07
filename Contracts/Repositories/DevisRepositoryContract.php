<?php


namespace Modules\CoreCRM\Contracts\Repositories;

use App\Models\Fournisseur;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface DevisRepositoryContract extends SearchableRepository, RepositoryFetchable
{
    public function create(Dossier $dossier, Commercial $commercial): DevisEntities;
    public function updateData(DevisEntities $devis, array $data): DevisEntities;
    public function updateFournisseur(DevisEntities $devis,Fournisseur $fournisseur): DevisEntities;

    public function getDevisByDossier(Dossier $dossier):LengthAwarePaginator;

    public function delete(DevisEntities $devis): bool;
}
