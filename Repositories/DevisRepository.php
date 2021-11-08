<?php


namespace Modules\CoreCRM\Repositories;



use App\Models\Fournisseur;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisUpdate;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Devi;
use Modules\CoreCRM\Models\Dossier;

class DevisRepository extends AbstractRepository implements DevisRepositoryContract
{

    public function create(Dossier $dossier, Commercial $commercial): DevisEntities
    {
        $devi = Devi::create([
            'dossier_id' => $dossier->id,
            'commercial_id' => $commercial->id,
            'data' => [],
            'tva_applicable' => true,
        ]);

        app(FlowContract::class)->add($dossier,new ClientDossierDevisCreate($devi, Auth::user()));

        return $devi;
    }

    public function updateData(DevisEntities $devis, array $data): Devi
    {
        $devis->data = $data;

        $devis->save();

        app(FlowContract::class)->add($devis->dossier,new ClientDossierDevisUpdate($devis, \Auth::user(), $data));

        return $devis;
    }

    public function updateFournisseur(DevisEntities $devis, Fournisseur $fournisseur): DevisEntities
    {
        $devis->fournisseur()->associate($fournisseur);
        return $devis;
    }

    public function delete(DevisEntities $devis): bool
    {
       return $devis->delete();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        $id = (int) $value - Devi::getNumStartRef();
        $query->where('id', $id);

        if(!HasInterface::has(DossierRepositoryContract::class, $parent)) {
            $query->orWhereHas('dossier', function ($query) use ($value) {
                return app(DossierRepositoryContract::class)->searchQuery($query, $value, $this);
            });
        }

        return $this->searchDates($query, $value);
    }

    public function getModel(): Model
    {
        return new Devi();
    }


    public function getDevisByDossier(Dossier $dossier, int $paginate = 15, string $order = 'DESC'): LengthAwarePaginator
    {
        return Devi::whereHas('dossier', function($query) use ($dossier){
                $query->where('id', $dossier->id);
            })
            ->orderBy('created_at', $order)
            ->paginate($paginate);
    }
}
