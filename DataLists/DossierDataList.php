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
                    'attribute' => function($item){
                        return ['label' => $item->status_label, 'color' => $item->status_color];
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
           'show' => [
               'permission' => ['view', Dossier::class],
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
            'permission' => ['create', ClientEntity::class],
            'route' => function($params){
//                dd($params);
                return route('dossiers.create', $params);
            },
            'label' => 'Ajouter un dossier',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        $repository = app(DossierRepositoryContract::class);
        $query = $repository->newQuery()->orderBy('created_at', 'desc');
        if($parents) {
            $repository->setQuery(
                $repository->filterByParents($query, $parents)
            );
        }else{
            $repository->setQuery($query);
        }

        return $repository;
    }
}
