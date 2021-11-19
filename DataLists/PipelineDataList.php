<?php


namespace Modules\CoreCRM\DataLists;


use Modules\BaseCore\Icons\Icons;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Models\Pipeline;
use Modules\DataListCRM\Abstracts\DataListType;

class PipelineDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'name' => [
                'label' => 'Pipeline',
                'lass' => 'w-36'
            ],
            "nbr_status" => [
                'label' => 'Nombre de status',
                'format' => function($item){
                    return $item->statuses->count();
                }
            ],
            "is_default" => [
                'label' => 'Default',
                'format' => function($item){
                   return ($item->is_default)? Icons::checkCircle(25, 'text-green-600'):'';
                }
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
                'permission' => ['update', Pipeline::class],
                'route' => function($params){
                    return route('pipelines.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Pipeline::class],
            'route' => function(){
                return route('pipelines.create');
            },
            'label' => 'Ajouter une pipeline',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(PipelineRepositoryContract::class);
    }
}
