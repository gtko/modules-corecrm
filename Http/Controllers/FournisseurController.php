<?php

namespace Modules\CoreCRM\Http\Controllers;

use Modules\BaseCore\Http\Controllers\AbstractTypeUserController;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\DataLists\FournisseurDataList;
use Modules\CoreCRM\Models\Fournisseur;


class FournisseurController extends AbstractTypeUserController
{

    function getTitle(): string
    {
        return 'Fournisseur';
    }

    function getDataList(): string
    {
        return FournisseurDataList::class;
    }

    function getName(): string
    {
        return 'fournisseur';
    }

    function getRouteName(): string
    {
        return 'fournisseurs';
    }

    function getModelClass(): string
    {
        return Fournisseur::class;
    }

    function getRepository()
    {
        return app(FournisseurRepositoryContract::class);
    }
}
