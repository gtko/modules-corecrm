<?php


namespace Modules\CoreCRM\DataLists;


use App\Models\Source;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\DataListCRM\Abstracts\DataListType;

class SourceDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'label' => [
                'label' => 'Source',
                'class' => 'w-36'
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
                'permission' => ['update', Source::class],
                'route' => function($params){
                    return route('sources.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Source::class],
            'route' => function(){
                return route('sources.create');
            },
            'label' => 'Ajouter un source',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(SourceRepositoryContract::class);
    }
}
