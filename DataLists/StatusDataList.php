<?php


namespace Modules\CoreCRM\DataLists;


use App\Models\Status;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\DataListCRM\Abstracts\DataListType;

class StatusDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'label' => [
                'label' => 'Status',
                'component' => [
                    'name' => 'corecrm::components.status',
                    'attribute' => function($item){
                        return [
                            'label' => $item->label,
                            'color' => $item->color
                        ];
                    }
                ],
                'class' => 'w-36'
            ],
            'weight' => [
                'label' => 'Ordre',
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
            'show' => [
                'permission' => ['show', Status::class],
                'route' => function($params){
                    return route('statuses.show', $params);
                },
                'label' => 'voir',
                'icon' => 'show'
            ],
            'edit' => [
                'permission' => ['update', Status::class],
                'route' => function($params){
                    return route('statuses.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Status::class],
            'route' => function(){
                return route('statuses.create');
            },
            'label' => 'Ajouter un status',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(StatusRepositoryContract::class);
    }
}
