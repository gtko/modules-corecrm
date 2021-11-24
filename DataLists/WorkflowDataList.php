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
