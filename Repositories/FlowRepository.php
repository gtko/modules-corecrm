<?php


namespace Modules\CoreCRM\Repositories;


use Modules\CoreCRM\Contracts\Repositories\FlowRepositoryContract;
use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Interfaces\Flowable;
use Modules\CoreCRM\Models\Flow;

class FlowRepository implements FlowRepositoryContract
{

    public function createFlow(Flowable $flowable, FlowAttributes $flowAttributes): Flow
    {
        $flow = new Flow();
        $flow->event()->associate($flowAttributes->event());
        $flow->flowable()->associate($flowable);
        $flow->datas = $flowAttributes;
        $flow->save();

        FlowAddEvent::dispatch($flow);

        return $flow;
    }
}
