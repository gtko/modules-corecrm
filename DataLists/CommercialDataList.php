<?php


namespace Modules\CoreCRM\DataLists;


use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmBe\Models\ProduitAudit;
use Modules\DataListCRM\Abstracts\DataListType;

class CommercialDataList extends DataListType
{
    public function getFields():array
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
                'action' => [
                    'permission' => ['edit', Commercial::class],
                    'route' => function($params){
                        return route('commercials.edit', $params);
                    },
                ]
            ],
            'email' => [
                'label' => 'Email'
            ],
            'phone' => [
                'label' => 'Téléphone'
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
               'permission' => ['update', Commercial::class],
               'route' => function($params){
                   return route('commercials.edit', $params);
               },
               'label' => 'edit',
               'icon' => 'edit'
           ],
           'delete' => [
               'method' => 'delete',
               'permission' => ['delete', Commercial::class],
               'route' => function ($params) {
                   return route('commercials.destroy', $params);
               },
               'label' => 'Supprimer',
               'icon' => 'delete'
           ],
       ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Commercial::class],
            'route' => function(){
                return route('commercials.create');
            },
            'label' => 'Ajouter un vendeur',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
       return app(CommercialRepositoryContract::class);
    }
}
