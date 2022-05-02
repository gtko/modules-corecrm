<?php namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Flow\Attributes\ClientDossierCreate;
use Modules\CoreCRM\Flow\Attributes\ClientDossierUpdate;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Tag;


class DossierRepository extends AbstractRepository implements DossierRepositoryContract
{


    public function create(ClientEntity $client, Commercial $commercial, Source $source, Status $status, array $data = null): Dossier
    {
        $dossier = new Dossier();

        $dossier->client()->associate($client);
        $dossier->commercial()->associate($commercial);
        $dossier->source()->associate($source);
        $dossier->status()->associate($status);
        $dossier->data = $data;
        $dossier->attribution = now();
        $dossier->date_start = Carbon::now();

        $dossier->save();

        app(FlowContract::class)->add($dossier, app(ClientDossierCreate::class, [Auth::user()]));

        return $dossier;
    }

    public function update(Dossier $dossierModel, Commercial $commercial): Dossier
    {
        $dossier = Dossier::find($dossierModel->id);
        $dossier->associate($commercial);

        if(Auth::check()) {
            app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user(), 'Mise à jours du dossier'));
        }

        return $dossier;
    }

    public function getAllDossiers(int $paginate = 15): LengthAwarePaginator
    {
        return Dossier::query()->paginate(15);
    }

    public function getDossiersByClient(ClientEntity $client, int $paginate = 15): LengthAwarePaginator
    {
        return $client->dossiers()->paginate(15);
    }


    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        $ref = (int)$value - Dossier::getNumStartRef();
        $query = $query->where('dossiers.id', $ref);

        $query->orWhereHas('status', function ($query) use ($value) {
            $query->where('label', 'LIKE', "%$value%");
        });

        if (!HasInterface::has(DevisRepositoryContract::class, $parent)) {
            $query->orWhereHas('devis', function ($query) use ($value) {
                return app(DevisRepositoryContract::class)->searchQuery($query, $value, $this);
            });
        }

        $query = $this->searchDates($query, $value);
        return $this->searchDates($query, $value, 'date_start');
    }

    public function getModel(): Model
    {
        return new Dossier();
    }

    public function filterByParents(Builder $query, array $parents): Builder
    {
        return $query->whereHas('client', function ($query) use ($parents) {
            $query->where('id', $parents[0] ?? null);
        });
    }

    public function changeCommercial(Dossier $dossier, Commercial $commercial): Dossier
    {
        $commercialOrigin = $dossier->commercial;
        $dossier->commercial()->associate($commercial);
        $dossier->attribution = now();
        $dossier->save();

        if(Auth::check()) {
            app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user(), 'Changement du commercial de '.$commercialOrigin->format_name. ' vers ' . $commercial->format_name));
        }

        return $dossier;
    }

    public function changeSource(Dossier $dossier, Source $source): Dossier
    {
        $sourceOrigin = $dossier->source;
        $dossier->source()->associate($source);
        $dossier->save();

        app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user(),'Changement de source '.$sourceOrigin->label. ' sur '. $source->label));

        return $dossier;
    }

    public function changeStatus(Dossier $dossier, Status $status): Dossier
    {
        $statusOrigin = $dossier->status;
        $dossier->status()->associate($status);
        $dossier->save();

        if(Auth::check()) {
            app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user(), 'Changement de status de '.$statusOrigin->label.' vers ' . $status->label));
        }

        return $dossier;
    }

    public function changeClient(Dossier $dossier, ClientEntity $client): Dossier
    {
        $clientOrigin = $dossier->client;
        $dossier->client()->associate($client);
        $dossier->save();

        if(Auth::check()) {
            app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user(), 'Changement du client de '.$clientOrigin->format_name.' vers ' . $client->format_name));
        }

        return $dossier;
    }

    public function changeData(Dossier $dossier, array $data = []): Dossier
    {
        $dossier->data = $data;
        $dossier->save();

        if(Auth::check()) {
            app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user(), 'Mise à jours des datas du dossier'));
        }

        return $dossier;
    }

    public function getDossiersByCommercial(Commercial $commercial): Builder
    {
        return $this->newQuery()->where('commercial_id', $commercial->id);
    }

    public function getDossiersByCommercialAndStatus(Commercial $commercial, Status $status): Collection|null
    {

        $collection = $this->newQuery()->where('commercial_id', $commercial->id)->where('status_id', $status->id)->get();

        return $collection->groupBy('client_id')->first();
    }

    public function getDossierNotAttribute(): Collection
    {
        return $this->getQueryDossierNotAttribute()->get();
    }

    public function getQueryDossierNotAttribute(): Builder
    {
        return $this->newQuery()->where('commercial_id', '1');
    }

    public function getDossierAttribute(): Collection
    {
        return $this->getQueryDossierAttribute()->get();

    }

    public function getQueryDossierAttribute(): Builder
    {
        return $this->newQuery()->where('commercial_id', '!=', '1')
            ->whereDate('created_at', '>', now()->subDays(7));

    }

    public function getDossierTrashed(): Collection
    {
        return $this->getQueryDossierTrashed()->get();
    }

    public function getQueryDossierTrashed(): Builder
    {
        return $this->newQuery()->onlyTrashed();
    }

    public function getSource(): Collection
    {
        return $this->newQuery()->get()->groupBy('source');
    }

    public function getByEmail(string $email): Collection
    {
        return Dossier::whereHas('client', (function ($query) use ($email) {
            $query->whereHas('personne', function ($query) use ($email) {
                $query->whereHas('emails', function ($query) use ($email) {
                    $query->where('email', $email);
                });
            });
        }))->get();
    }

    public function getByPhone(string $phone): Collection
    {
        return Dossier::whereHas('client', (function ($query) use ($phone) {
            $query->whereHas('personne', function ($query) use ($phone) {
                $query->whereHas('phones', function ($query) use ($phone) {
                    $query->where('phone', 'LIKE' , '%'.$phone.'%');
                });
            });
        }))->get();
    }

    public function getDossierByClientAndStatus(Client $client, Status $status): Collection
    {
        return Dossier::where('clients_id', $client->id)
            ->where('status_id', $status->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function countDossierBlancByCommercial(Commercial $commercial): int
    {
        if($commercial->hasRole('super-admin')) {
            return 0;
        }

        $status = app(StatusRepositoryContract::class)
            ->newQuery()
            ->where('type', StatusTypeEnum::TYPE_NEW)
            ->first();

        $count = $this->getDossiersByCommercialAndStatus($commercial, $status);
        if ($count == null) {
            return 0;
        }

        return $count->count();

    }


    public function countDossierNewWithoutCommercial():int
    {
        return Dossier::where('commercial_id', 1)
            ->count();
    }


}
