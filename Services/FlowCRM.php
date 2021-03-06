<?php


namespace Modules\CoreCRM\Services;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Contracts\Repositories\FlowRepositoryContract;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Interfaces\Flowable;
use Modules\CoreCRM\Models\Flow;

class FlowCRM implements FlowContract
{

    public function add(Flowable $flowable, FlowAttributes $flowAttributes, array $override_data = []): Flow
    {
        return app(FlowRepositoryContract::class)->createFlow($flowable, $flowAttributes, $override_data);
    }

    public function list(Flowable $flowable): Collection
    {
       return $flowable->flow()->with('event')->orderByDesc('created_at')->get();
    }

    public function has(Flowable $flowable, Collection $events): bool
    {
        $event_ids = $events->pluck('id');
        $query = $flowable->query();
        foreach($event_ids as $id){
            $query->whereHas('flow', function($query) use ($id){
                $query->where('event_id', $id);
            });
        }

        return $query->count() > 0;
    }
}
