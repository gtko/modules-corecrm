<?php


namespace Modules\CoreCRM\DataLists;


use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Client;
use Modules\DataListCRM\Abstracts\DataListType;

class ClientDataList extends DataListType
{
    public function getFields():array
    {
        return [
            'avatar_url' => [
                'label' => '',
                'component' => [
                    'name' => 'basecore::components.avatar',
                    'attribute' => 'url'
                ],
            ],
            'format_name' => [
                'label' => 'Nom',
                'action' => [
                    'permission' => ['show', ClientEntity::class],
                    'route' => function($params){
                        return route('clients.show', $params);
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
           'show' => [
               'permission' => ['show', ClientEntity::class],
               'route' => function($params){
                   return route('clients.show', $params);
               },
               'label' => 'voir',
               'icon' => 'show'
           ],
           'edit' => [
               'permission' => ['update', ClientEntity::class],
               'route' => function($params){
                   return route('clients.edit', $params);
               },
               'label' => 'edit',
               'icon' => 'edit'
           ],
       ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', ClientEntity::class],
            'route' => function(){
                return route('clients.create');
            },
            'label' => 'Ajouter un client',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []):RepositoryFetchable
    {
        return app(ClientRepositoryContract::class);
    }
}
