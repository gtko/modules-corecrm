<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Models\Dossier;

class Timeline extends Component
{
    public $dossier;

    protected $listeners =
        [
            'refreshTimeline' => '$refresh'
        ];

    public function mount(Dossier $dossier): void
    {
        $this->dossier = $dossier;
    }

    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(FlowContract $flowService): View|string
    {
        $flows = $flowService->list($this->dossier);

        $flows = $flows->map(function ($item) {
            $item->day = $item->created_at->format('d/m/Y');
            return $item;
        })->groupBy('day');

        return view('corecrm::livewire.timeline', [
            'flows' => $flows
        ]);
    }
}
