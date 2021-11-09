<?php namespace Modules\CoreCRM\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Flow\Attributes\ClientDossierCreate;
use Modules\CoreCRM\Flow\Attributes\ClientDossierUpdate;
use Modules\CoreCRM\Models\Client;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;


class DossierRepository extends AbstractRepository implements DossierRepositoryContract
{


    public function create(ClientEntity $client, Commercial $commercial, Source $source, Status $status): Dossier
    {
        $dossier = new Dossier();

        $dossier->client()->associate($client);
        $dossier->commercial()->associate($commercial);
        $dossier->source()->associate($source);
        $dossier->status()->associate($status);
        $dossier->date_start = Carbon::now();

        $dossier->save();

        app(FlowContract::class)->add($dossier, new ClientDossierCreate(Auth::user()));

        return $dossier;
    }

    public function update(Dossier $dossierModel, Commercial $commercial): Dossier
    {
        $dossier = Dossier::find($dossierModel->id);
        $dossier->associate($commercial);

        app(FlowContract::class)->add($dossier, new ClientDossierUpdate(Auth::user()));

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
        $query = $query->where('id', $ref);

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
        $dossier->commercial()->associate($commercial);
        $dossier->save();

        return $dossier;
    }

    public function changeSource(Dossier $dossier, Source $source): Dossier
    {
        $dossier->source()->associate($source);
        $dossier->save();

        return $dossier;
    }

    public function changeStatus(Dossier $dossier, Status $status): Dossier
    {
        $dossier->status()->associate($status);
        $dossier->save();

        return $dossier;
    }

    public function changeClient(Dossier $dossier, ClientEntity $client): Dossier
    {
        $dossier->client()->associate($client);
        $dossier->save();

        return $dossier;
    }

    public function getDossiersByCommercialAndStatus(Commercial $commercial, Status $status): Collection
    {
        $collection = Dossier::where('commercial_id', $commercial->id)->where('status_id', $status->id)->get();

        return $collection->groupBy('client_id')->first();
    }

    public function getDossierNotAttribute(): Collection
    {
        return Dossier::where('commercial_id', '1')->get();
    }

    public function getDossierAttribute(): Collection
    {
        return Dossier::where('commercial_id', '!=', '1')->get();

    }

    public function getDossierTrashed(): Collection
    {
        return Dossier::all();
    }

    public function getSource(): Collection
    {
        return Dossier::all()->groupBy('source');
    }

    public function getByEmail(string $email): Collection
    {
        $dossiers = Dossier::whereHas('client', (function ($query) use ($email) {
            $query->whereHas('personne', function ($query) use ($email) {
                $query->whereHas('emails', function ($query) use ($email) {
                    $query->where('email', $email);
                });
            });
        }))->get();

        return $dossiers;
    }

    public function getByPhone(string $phone): Collection
    {
        $dossiers = Dossier::whereHas('client', (function ($query) use ($phone) {
            $query->whereHas('personne', function ($query) use ($phone) {
                $query->whereHas('phones', function ($query) use ($phone) {
                    $query->where('phone', $phone);
                });
            });
        }))->get();

        return $dossiers;
    }
}
