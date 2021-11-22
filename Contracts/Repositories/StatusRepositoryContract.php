<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface StatusRepositoryContract extends SearchableRepository, RepositoryFetchable,RelationsRepositoryContract
{

    public function create(Pipeline $pipeline, string $label, string $color,int $order, string $type):Status;
    public function update(Status $status, string $label, string $color,int $order, string $type):Status;

    public function existByLabel(string $label):bool;
    public function findByLabel(string $label):?Status;
    public function getById(int $id):Status;

    public function changePipeline(Status $status,  Pipeline $pipeline):Status;
    public function updateOrder(Status $status, int $order):Status;

    public function delete(Status $status):bool;

}
