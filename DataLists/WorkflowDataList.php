<?php


namespace Modules\CoreCRM\DataLists;


use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Models\Workflow;
use Modules\DataListCRM\Abstracts\DataListType;

class WorkflowDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'name' => [
                'label' => 'Nom',
                'lass' => 'w-36'
            ],

            "active" => [
                'label' => 'actif',
                'component' => [
                    'name' => 'crmautocar::components.workflow-actif',
                    'attribute' => function($item){
                        return [
                            'workflow' => $item,
                        ];
                    }
                ]
            ],
        ];
    }

    public function getActions(): array
    {
        return [
            'edit' => [
                'permission' => ['update', Workflow::class],
                'route' => function($params){
                    return route('workflows.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
            'delete' => [
                'method' => 'delete',
                'permission' => ['delete', Workflow::class],
                'route' => function($params){
                    return route('workflows.destroy', $params);
                },
                'label' => 'Supprimer',
                'icon' => 'delete'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Workflow::class],
            'route' => function(){
                return route('workflows.create');
            },
            'label' => 'Ajouter un workflow',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(WorkflowRepositoryContract::class);
    }
}
