<?php

namespace Modules\CoreCRM\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Modules\CoreCRM\Models\Flow;
use Modules\CrmAutoCar\Services\FilterBureau;

class TimelineResolve extends Component
{

    public function __construct(
      public Flow $flow
    ){}

    public function resolve(){
        try {
            $nameComponent = Str::replace('Flow\Attributes', "View\Components\Timeline", $this->flow->datas->getKeyEvent());
            if (class_exists($nameComponent)) {
                $component = (new $nameComponent($this->flow));
                return $component->render()->with(['flow' => $this->flow]);
            }
        } catch (\Exception $e) {
            return view('corecrm::components.timeline-error');
        }

        return null;
    }

    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
//        app(FilterBureau::class)->desactivateFilter();
        try {
//            if ($this->flow->datas->componentCacheable()) {
//                $view = Cache::rememberForever('timeline_v7_flow_' . $this->flow->id . '_' . $this->flow->updated_at, function () {
//                    return $this->resolve();
//                });
//            } else {
                $view = $this->resolve();
//            }
        } catch (\Exception $e) {
            $view = view('corecrm::components.timeline-error', ['flow' => $this->flow]);
        }
//        app(FilterBureau::class)->activateFilter();

        return $view;
    }
}
