<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;
use Modules\CoreCRM\Models\Dossier;

class SheduleAttribute extends Attributes
{
    protected ?Dossier $dossier;

    public function __construct(?Dossier $dossier = null)
    {
        parent::__construct();
        $this->dossier = $dossier;
    }

    public static function instance(array $value): FlowAttributes
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id'] ?? 0);
        return app(SheduleAttribute::class, [
            'dossier' => $dossier
        ]);
    }

    public function toArray(): array
    {
       return [
           'dossier_id' => $this->dossier->id ?? null,
       ];
    }


    public function getDossier():Dossier
    {
        return $this->dossier;
    }

}
