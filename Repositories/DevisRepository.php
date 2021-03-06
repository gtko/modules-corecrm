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

    public function create(Dossier $dossier, Commercial $commercial, string $title = null): DevisEntities
    {
        $devi = app(DevisEntities::class)::create([
            'dossier_id' => $dossier->id,
            'commercial_id' => $commercial->id,
            'data' => [],
            'tva_applicable' => true,
            'title' => $title
        ]);

        app(FlowContract::class)->add($dossier, new ClientDossierDevisCreate($devi, Auth::user()));

        return $devi;
    }

    public function duplicate(DevisEntities $devis): DevisEntities
    {


        $newDevis = app(DevisEntities::class)::create([
            'dossier_id' => $devis->dossier->id,
            'commercial_id' => $devis->commercial->id,
            'data' => [
                'trajets' => $devis->data['trajets'] ?? [],
                'lines' => $devis->data['lines'] ?? [],
                'nombre_bus' => $devis->data['nombre_bus'] ?? '',
                'nombre_chauffeur' => $devis->data['nombre_chauffeur'] ?? '',
            ],
            'tva_applicable' => $devis->tva_applicable,
        ]);

        app(FlowContract::class)->add($newDevis->dossier, new ClientDossierDevisCreate($newDevis, Auth::user()));

        return $newDevis;
    }

    public function updateData(DevisEntities $devis, array $data, string $title = null): DevisEntities
    {
        $devis->data = $data;
        $devis->title = $title;
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


    public function delete(DevisEntities $devis): bool
    {
        if (!$devis->proformat) {
            return $devis->delete();
        }
        return false;

    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        $devis = app(DevisEntities::class);
        $devisRef = str_replace($devis::getPrefixRef(), '', $value);
        $id = (int)$devisRef - $devis::getNumStartRef();
        $query->where('id', $id)
            ->orWhere('title', $value);

//        if (!HasInterface::has(DossierRepositoryContract::class, $parent)) {
//            $query->orWhereHas('dossier', function ($query) use ($value) {
//                return app(DossierRepositoryContract::class)->searchQuery($query, $value, $this);
//            });
//        }

        return $this->searchDates($query, $value);
    }

    public function getModel(): Model
    {
        return app(DevisEntities::class);
    }


    public function getDevisByDossier(Dossier $dossier, int $paginate = 15, string $order = 'DESC'): LengthAwarePaginator
    {
        return $this->newQuery()->whereHas('dossier', function ($query) use ($dossier) {
            $query->where('id', $dossier->id);
        })
            ->orderBy('created_at', $order)
            ->paginate($paginate);
    }

    public function getFournsisseurValidate(DevisEntities $devi): Collection
    {
        return $devi->fournisseurs()->wherePivot('validate', true)->get();

    }

    public function getPrice(DevisEntities $devi, Fournisseur $fournisseur): float
    {
        $fournisseur =  $devi->fournisseurs()->where('id', $fournisseur->id)->first();
        return $fournisseur->pivot['prix'] ?? 0.0;
    }

    public function validatedDevis(DevisEntities $devi, array $data): bool
    {
        $newData = array_merge($devi->data, $data);
        $devi->data = $newData;
        return $devi->save();

    }

    public function validateFournisseur(DevisEntities $devis, Fournisseur $fournisseur, bool $validate = true)
    {
        $devis->fournisseurs()->updateExistingPivot($fournisseur, ['validate' => $validate, 'refused' => !$validate]);

        return $devis;
    }

    public function refusedFournisseur(DevisEntities $devis, Fournisseur $fournisseur, bool $refused = true): DevisEntities
    {
        $devis->fournisseurs()->updateExistingPivot($fournisseur, ['validate' => !$refused, 'refused' => $refused]);

        return $devis;
    }

    public function sendDemandeFournisseur(DevisEntities $devis, Fournisseur $fournisseur, Carbon $mail_sended = null, bool $validate = false): DevisEntities
    {
        $demandeFournisseur = new DemandeFournisseur();
        $demandeFournisseur->fournisseur()->associate($fournisseur);
        $demandeFournisseur->devis()->associate($devis);
        $demandeFournisseur->mail_sended = $mail_sended;
        $demandeFournisseur->validate = $validate;
        $demandeFournisseur->save();

        return $devis;
    }


    public function savePriceFournisseur(DevisEntities $devis, Fournisseur $fournisseur, float $price): DevisEntities
    {
        $devis->fournisseurs()->updateExistingPivot($fournisseur, ['prix' => $price]);

        return $devis;
    }

    public function addTitre(DevisEntities $devis, string $title): DevisEntities
    {
        $devis->title = $title;

        return $devis;
    }

    public function changeCommercial(DevisEntities $devis, Commercial $commercial): DevisEntities
    {
        $devis->commercial_id = $commercial->id;
        $devis->save();

        return $devis;
    }

}
