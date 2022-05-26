<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Models\Dossier;

class Timeline extends Component
{
    public $dossier;
    public $inverse = false;
    public $filter = 'all';
    public $polling = false;

    protected $listeners =
        [
            'refreshTimeline' => '$refresh'
        ];

    public function mount(Dossier $dossier, $inverse = false, $polling = false): void
    {
        $this->dossier = $dossier;
        $this->inverse = $inverse;
        $this->polling = $polling;
    }

    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(FlowContract $flowService): View|string
    {
        $flows = $flowService->list($this->dossier);


        $flows = $flows
            ->filter(function ($flow) {
                return $this->filter === 'all' || $flow->datas->getType() === $this->filter;
            })
            ->map(function ($item) {
            $item->day = $item->created_at->format('d/m/Y');
            return $item;
        });

        if($this->inverse) {
            $flows = $flows->reverse();
        }

        $flows = $flows->groupBy('day');

        return view('corecrm::livewire.timeline', [
            'flows' => $flows
        ]);
    }
}
