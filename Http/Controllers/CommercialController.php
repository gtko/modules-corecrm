<?php

namespace Modules\CoreCRM\Http\Controllers;


use Modules\BaseCore\Http\Controllers\AbstractTypeUserController;
use Modules\CoreCRM\DataLists\CommercialDataList;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Repositories\CommercialRepository;

class CommercialController extends AbstractTypeUserController
{
    public function getTitle(): string
    {
        return 'Vendeur';
    }

    public function getDataList(): string
    {
       return CommercialDataList::class;
    }

    public function getName(): string
    {
       return 'Vendeur';
    }

    public function getRouteName(): string
    {
      return 'commercials';
    }

    public function getModelClass(): string
    {
        return  Commercial::class;
    }

    function getRepository()
    {
        return app(CommercialRepository::class);
    }
}
