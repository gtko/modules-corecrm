<?php


namespace Modules\CoreCRM\DataLists;


use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\DataListCRM\Abstracts\DataListType;

class DevisDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'ref' => [
                'label' => 'Ref',
                'format' => function($item){
                    return "#".$item->ref;
                },
                'action' => [
                    'permission' => ['update', DevisEntities::class],
                    'route' => function($params){
                        return route('devis.edit', $params);
                    }
                ]
            ],
            'commercial' => [
                'label' => 'Commercial',
                'component' => [
                    'name' => 'basecore::components.personne.personne-badge',
                    'attribute' => 'personne'
                ]
            ],
            'created_at' => [
                'label' => 'Créer le',
                'format' => function($item){
                    return $item->created_at->format('d/m/Y');
                }
            ]
        ];
    }

    public function getActions(): array
    {
        return [
            'edit' => [
                'permission' => ['update', DevisEntities::class],
                'route' => function($params){
                    return route('devis.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(DevisRepositoryContract::class);
    }
}
