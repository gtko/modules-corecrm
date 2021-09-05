<?php


namespace Modules\CoreCRM\DataLists;

use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Dossier;
use Modules\DataListCRM\Abstracts\DataListType;

class DossierDataList extends DataListType
{
    public function getFields():array
    {
        return [
            'ref' => [
                'label' => 'Ref',
                'action' => [
                    'permission' => ['show', Dossier::class],
                    'route' => function($params){
                        return route('dossiers.show', $params);
                    },
                ],
                'format' => function($item){
                    return '#'.$item->ref;
                }
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
            'client' => [
                'label' => 'Client',
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
            'permission' => ['create', Dossier::class],
            'route' => function($params){
                return route('dossiers.create', $params);
            },
            'label' => 'Ajouter un dossier',
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
