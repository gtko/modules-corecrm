<?php

namespace Modules\CoreCRM\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Models\Dossier;

class Timeline extends Component
{
    public int $dossier;

    public function mount(int $dossier): void
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
        $dossier = Dossier::find($this->dossier);
        $flows = $flowService->list($dossier);
        $flows = $flows->map(function($item){
            $item->day = $item->created_at->format('d/m/Y');
            return $item;
        })->groupBy('day');

        return view('corecrm::livewire.timeline', [
            'flows' => $flows
        ]);
    }
}
