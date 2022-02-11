<?php


namespace Modules\CoreCRM\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\BaseCore\Models\User;
use Modules\CoreCRM\Models\Fournisseur;

class SendContactChauffeurToClient extends Attributes
{
    protected UserEntity $user;
    protected DevisEntities $devis;
    protected Fournisseur $fournisseur;

    public function __construct(UserEntity $user, DevisEntities $devis, Fournisseur $fournisseur)
    {
        parent::__construct();
        $this->user = $user;
        $this->devis = $devis;
        $this->fournisseur = $fournisseur;
    }

    public static function instance(array $value): FlowAttributes
    {
        $user = app(UserEntity::class)::find($value['user_id']);
        $devis = app(DevisEntities::class)::find($value['devi_id']);
        $fournisseur = app(FournisseurRepositoryContract::class)->fetchById($value['fournisseur_id']);
        return new SendContactChauffeurToClient($user, $devis, $fournisseur);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'devi_id' => $this->devis->id,
            'fournisseur_id' => $this->fournisseur->id,
        ];
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function getDevis(): DevisEntities
    {
        return $this->devis;
    }

    public function getFournisseur(): Fournisseur
    {
        return $this->fournisseur;
    }

}
