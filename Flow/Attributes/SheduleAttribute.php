<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;

class SheduleAttribute extends Attributes
{
    protected ?Dossier $dossier;
    protected ?DevisEntities $devis;

    public function __construct(?Dossier $dossier = null, ?DevisEntities $devis = null)
    {
        parent::__construct();
        $this->dossier = $dossier;
        $this->devis = $devis;
    }

    public static function instance(array $value): FlowAttributes
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id'] ?? 0);
        $devis = app(DevisRepositoryContract::class)->fetchById($value['devis_id'] ?? 0);
        return app(SheduleAttribute::class, [
            'dossier' => $dossier,
            'devis' => $devis,
        ]);
    }

    public function toArray(): array
    {
       return [
           'dossier_id' => $this->dossier->id ?? null,
           'devis_id' => $this->devis->id ?? null,
       ];
    }


    public function getDossier():Dossier
    {
        return $this->dossier;
    }

    public function getDevis():DevisEntities
    {
        return $this->devis;
    }

}
