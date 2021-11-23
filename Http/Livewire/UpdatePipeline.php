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
    public string $name = '';

    public array $form = [];
    public array $new = [];
    public array $win = [];
    public array $lost = [];

    protected $rules = [
        'name' => '',
        'form.*' => '',
        'new' => '',
        'win' => '',
        'lost' => ''
    ];

    public function mount(Pipeline $pipeline){
        $this->pipeline = $pipeline;

        $this->name = $this->pipeline->name;

        $statuses = $this->pipeline->statuses()->whereNotIn('type',[StatusTypeEnum::TYPE_WIN,StatusTypeEnum::TYPE_LOST,StatusTypeEnum::TYPE_NEW] )->get();
        foreach($statuses as $order => $status){
            $this->form[$status->order] = $status->toArray();
        }

        $this->new = $this->pipeline->status_new->toArray();
        $this->win = $this->pipeline->status_win->toArray();
        $this->lost = $this->pipeline->status_lost->toArray();

    }

    public function store(StatusRepositoryContract $statusRep, PipelineRepositoryContract $pipelineRep){

        $status = [
            -101 => $this->new,
            ...$this->form,
            900 => $this->win,
            901 => $this->lost
        ];

        $pipelineRep->updateName($this->pipeline, $this->name);
        $pipelineRep->updateStatus($this->pipeline, $status);

        return redirect()->route('pipelines.index');
    }


    public function updateStatusOrder(StatusRepositoryContract $statusRep,$idsPositon)
    {
            $form = [];
            $collect = collect($this->form);
            foreach($idsPositon as $position){
                $order = $position['order'];
                $status = $collect->where('id', $position['value'])->first();
                $status['order'] = $order;
                $form[$order] = $status;
            }
            $this->form = $form;
    }

    public function addStatus(){
        $this->form[] = [
            'id' => uniqid('unique_', true),
            'label' => "",
            'color' => ""
        ];
    }

    public function removeStatus($status_id)
    {
        $this->form = collect($this->form)->filter(function($status) use ($status_id){
            return $status['id'] !== $status_id;
        })->toArray();
    }

    public function render()
    {
        $statuses = $this->pipeline->statuses()->whereNotIn('type',[StatusTypeEnum::TYPE_WIN,StatusTypeEnum::TYPE_LOST,StatusTypeEnum::TYPE_NEW] )->get();
        return view('corecrm::livewire.update-pipeline', compact('statuses'));
    }
}
