<?php


namespace Modules\CoreCRM\DataLists;

use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Dossier;
use Modules\DataListCRM\Abstracts\DataListType;

class DossierDataList extends DataListType
{
    public function getFields():array
    {
        return [
            'avatar_url' => [
                'label' => '',
                'component' => [
                    'name' => 'basecore::components.avatar',
                    'attribute' => function($attribute){
                        return ['url' => $attribute->client->avatar_url];
                    },
                ],
            ],
            'ref' => [
                'label' => 'Ref',
                'format' => function($item){
                    return '#'.$item->ref;
                }
            ],
            'format_name' => [
                'label' => 'Nom',
                'format' => function($item){
                    return $item->client->format_name;
                },
            ],
            'status_label' => [
                'label' => 'Statut',
                'component' => [
                    'name' => 'corecrm::components.status',
                    'attribute' => 'label'
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
           'show' => [
               'permission' => ['show', Dossier::class],
               'params' => function($item){
                    return [
                        $item->client->id,
                        $item->id
                    ];
               },
               'route' => function($params){
                   return route('dossiers.show', $params);
               },
               'label' => 'voir',
               'icon' => 'show'
           ]
       ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Client::class],
            'route' => function($params){
                return route('clients.create', $params);
            },
            'label' => 'Ajouter un client',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        $repository = app(DossierRepositoryContract::class);
        if($parents) {
            $repository->setQuery(
                $repository->filterByParents($repository->newQuery(), $parents)
            );
        }
        return $repository;
    }
}
