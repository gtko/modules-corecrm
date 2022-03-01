<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryFilters;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Tag;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface DossierRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryFilters, RepositoryQueryCustom, RelationsRepositoryContract
{

    public function create(ClientEntity $client, Commercial $commercial, Source $source, Status $status, array $data = null): Dossier;

    public function changeCommercial(Dossier $dossier, Commercial $commercial): Dossier;

    public function changeSource(Dossier $dossier, Source $source): Dossier;

    public function changeStatus(Dossier $dossier, Status $status): Dossier;

    public function changeClient(Dossier $dossier, ClientEntity $client): Dossier;

    public function getDossiersByCommercialAndStatus(Commercial $commercial, Status $status): Collection | null;

    public function getDossiersByClient(ClientEntity $client, int $paginate): ?LengthAwarePaginator;

    public function getDossierByClientAndStatus(Client $client, Status $status): Collection;

    public function getByEmail(string $email): Collection;

    public function getByPhone(string $phone): Collection;

    public function getDossierNotAttribute(): Collection;

    public function getDossierAttribute(): Collection;

    public function getDossierTrashed(): Collection;

    public function countDossierBlancByCommercial(Commercial $commercial): int;
    public function countDossierNewWithoutCommercial(): int;

}
