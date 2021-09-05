<?php


namespace Modules\CoreCRM\DataLists;


use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\BaseCore\Models\User;
use Modules\DataListCRM\Abstracts\DataListType;

class FournisseurDataList extends DataListType
{
    public function getFields(): array
    {
        return [
            'avatar_url' => [
                'label' => '',
                'component' => [
                    'name' => 'basecore::components.avatar',
                    'attribute' => 'url'
                ]
            ],
            'format_name' => [
                'label' => 'Nom',
            ],
            'email' => [
                'label' => 'Email'
            ],
            'phone' => [
                'label' => 'Téléphone'
            ],
            'created_at' => [
                'label' => 'Créer le',
                'format' => function ($item) {
                    return $item->created_at->format('d/m/Y');
                }
            ]
        ];
    }

    public function getActions(): array
    {
        return [
            'edit' => [
                'permission' => ['update', User::class],
                'route' => function ($params) {
                    return route('fournisseurs.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Fournisseur::class],
            'route' => function () {
                return route('fournisseurs.create');
            },
            'label' => 'Ajouter un fournisseur',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(FournisseurRepositoryContract::class);
    }
}
