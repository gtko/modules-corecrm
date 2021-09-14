<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Interfaces\Flowable;
use Modules\CoreCRM\Models\Flow;

interface FlowRepositoryContract extends RelationsRepositoryContract
{
    public function createFlow(Flowable $flowable, FlowAttributes $flowAttributes): Flow;

}
