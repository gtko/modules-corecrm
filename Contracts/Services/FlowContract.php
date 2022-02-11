<?php


namespace Modules\CoreCRM\Contracts\Services;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Interfaces\Flowable;
use Modules\CoreCRM\Models\Flow;

interface FlowContract
{
    public function add(Flowable $flowable, FlowAttributes $flowAttributes):Flow;

    public function list(Flowable $flowable):Collection;

    public function has(Flowable $flowable, Collection $events):bool;
}
