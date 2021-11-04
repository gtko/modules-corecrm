<?php


namespace Modules\CoreCRM\Repositories;


use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;

class DevisRepository extends AbstractRepository implements DevisRepositoryContract
{

    public function create(Dossier $dossier, Commercial $commercial): DevisEntities
    {
        $devi = app(DevisEntities::class)::create([
            'dossier_id' => $dossier->id,
            'commercial_id' => $commercial->id,
            'data' => [],
            'tva_applicable' => true,
        ]);

        app(FlowContract::class)->add($dossier, new ClientDossierDevisCreate($devi, Auth::user()));

        return $devi;
    }

    public function updateData(DevisEntities $devis, array $data): DevisEntities
    {
        $devis->data = $data;

        $devis->save();

        app(FlowContract::class)->add($devis->dossier, new ClientDossierDevisUpdate($devis, \Auth::user(), $data));

        return $devis;
    }

    public function updateFournisseur(DevisEntities $devis, Fournisseur $fournisseur): DevisEntities
    {
        $devis->fournisseur()->associate($fournisseur);
        $devis->save();

        return $devis;
    }

    public function detachFournisseur(DevisEntities $devis, Fournisseur $fournisseur): bool
    {
        return $devis->fournisseurs()->detach($fournisseur);
    }

    public function validateFournisseur(DevisEntities $devis, Fournisseur $fournisseur, bool $validate = true,)
    {
        $devis->fournisseurs()->updateExistingPivot($fournisseur, ['validate' => $validate]);

        return $devis;
    }

    public function sendPriceFournisseur(DevisEntities $devis, Fournisseur $fournisseur, float $prix = null, Carbon $mail_sended = null, bool $validate = false): DevisEntities
    {
        $devis->fournisseurs()->detach($fournisseur);
        $devis->fournisseurs()->attach($fournisseur, ['prix' => $prix, 'validate' => $validate, 'mail_sended' => $mail_sended]);

        return $devis;
    }

    public function delete(DevisEntities $devis): bool
    {
        return $devis->delete();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        $id = (int)$value - app(DevisEntities::class)::getNumStartRef();
        $query->where('id', $id);

        if (!HasInterface::has(DossierRepositoryContract::class, $parent)) {
            $query->orWhereHas('dossier', function ($query) use ($value) {
                return app(DossierRepositoryContract::class)->searchQuery($query, $value, $this);
            });
        }

        return $this->searchDates($query, $value);
    }

    public function getModel(): Model
    {
        return app(DevisEntities::class);
    }


    public function getDevisByDossier(Dossier $dossier, int $paginate = 15, string $order = 'DESC'): LengthAwarePaginator
    {
        return app(DevisEntities::class)::whereHas('dossier', function ($query) use ($dossier) {
            $query->where('id', $dossier->id);
        })
            ->orderBy('created_at', $order)
            ->paginate($paginate);
    }

    public function getFournsisseurValidate(DevisEntities $devi) :Collection
    {
        return $devi->fournisseurs()->wherePivot('validate', true)->get();

    }

    public function getPrice(DevisEntities $devi, Fournisseur $fournisseur): float
    {

        return $devi->fournisseurs()->where('personne_id' , $fournisseur->id)->first()->pivot['prix'] ?? 0.0;
    }
    public function validatedDevis(DevisEntities $devi, array $data): bool
    {
        $newData =  array_merge($devi->data, $data);
        $devi->data = $newData;
        return $devi->save();

    }
}
