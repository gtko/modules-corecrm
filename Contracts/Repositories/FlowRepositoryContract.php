<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Interfaces\Flowable;
use Modules\CoreCRM\Models\Flow;

interface FlowRepositoryContract
{
    public function createFlow(Flowable $flowable, FlowAttributes $flowAttributes, array $override_data = []): Flow;

}
