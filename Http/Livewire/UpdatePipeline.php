<?php

namespace Modules\CoreCRM\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;

class UpdatePipeline extends Component
{
    /**
     * @var Pipeline $pipeline
     */
    public $pipeline;

    public function mount(Pipeline $pipeline){
        $this->pipeline = $pipeline;
    }

    public function store(){



    }


    public function updateStatusOrder(StatusRepositoryContract $statusRep,$idsPositon)
    {
        foreach($idsPositon as $position)
        {
            $status = $this->pipeline->statuses->where('id', $position['value'])->first();
            $statusRep->updateOrder($status, $position['order']);
        }
    }

    public function addStatus(StatusRepositoryContract $statusRep){
        $statusRep->create($this->pipeline, 'nouveau status ' . $this->pipeline->next_order_status, 'gray',$this->pipeline->next_order_status, StatusTypeEnum::TYPE_CUSTOM);
    }

    public function removeStatus(StatusRepositoryContract $statusRep,$status_id)
    {
        $statusRep->delete($this->pipeline->statuses->where('id', $status_id)->first());
    }

    public function render()
    {
        $statuses = $this->pipeline->statuses()->get();
        return view('corecrm::livewire.update-pipeline', compact('statuses'));
    }
}
