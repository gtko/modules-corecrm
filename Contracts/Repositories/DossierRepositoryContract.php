<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Illuminate\Pagination\LengthAwarePaginator;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryFilters;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface DossierRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryFilters, RepositoryQueryCustom
{

    public function create(ClientEntity $client, Commercial $commercial, Source $source, Status $status): Dossier;

    public function changeCommercial(Dossier $dossier, Commercial $commercial):Dossier;
    public function changeSource(Dossier $dossier, Source $source):Dossier;
    public function changeStatus(Dossier $dossier, Status $status):Dossier;
    public function changeClient(Dossier $dossier, ClientEntity $client):Dossier;

    public function getDossiersByClient(ClientEntity $client,int $paginate): ?LengthAwarePaginator;
}
