<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Http\Requests\PipelineStoreRequest;
use Modules\CoreCRM\Http\Requests\PipelineUpdateRequest;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;

class PipelinesController extends Controller
{
    public function index()
    {
        $this->authorize('views-any', Pipeline::class);

        return view('corecrm::app.pipeline.index');
    }

    public function create()
    {
        $this->authorize('create', Pipeline::class);

        return view('corecrm::app.pipeline.create');
    }

    public function store(PipelineStoreRequest $request, PipelineRepositoryContract $pipRep)
    {
        $this->authorize('create', Pipeline::class);

        $pipeline = $pipRep->create($request->name);

        return redirect()
            ->route('pipelines.edit', $pipeline)
            ->withSuccess(__('basecore::crud.common.created'));
    }


    public function edit(Pipeline $pipeline)
    {
        $this->authorize('update', $pipeline);

        return view('corecrm::app.pipeline.edit', compact('pipeline'));
    }

    public function update(PipelineUpdateRequest $request, Pipeline $pipeline)
    {

        dd($request->toArray());

    }

    public function destroy(Pipeline $pipeline)
    {
        //
    }
}
