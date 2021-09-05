<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Http\Requests\SourceStoreRequest;
use Modules\CoreCRM\Http\Requests\SourceUpdateRequest;
use Modules\CoreCRM\Models\Source;

class SourceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request): View|Factory|Application
    {
        $this->authorize('views-any', Source::class);

        return view('corecrm::app.sources.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request): View|Factory|Application
    {
        $this->authorize('create', Source::class);

        return view('corecrm::app.sources.create');
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\SourceStoreRequest $request
     * @param \Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract $sourceRep
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(SourceStoreRequest $request, SourceRepositoryContract $sourceRep)
    {
        $this->authorize('create', Source::class);
        $source = $sourceRep->create($request->label);

        return redirect()
            ->route('sources.edit', $source)
            ->withSuccess(__('basecore::crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\Source $source
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Source $source): View|Factory|Application
    {
        $this->authorize('views', $source);

        return view('corecrm::app.sources.show', compact('source'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\Source $source
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, Source $source): View|Factory|Application
    {
        $this->authorize('update', $source);

        return view('corecrm::app.sources.edit', compact('source'));
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\SourceUpdateRequest $request
     * @param \Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract $sourceRep
     * @param \Modules\CoreCRM\Models\Source $source
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(SourceUpdateRequest $request, SourceRepositoryContract $sourceRep,Source $source)
    {
        $this->authorize('update', $source);

        $source = $sourceRep->update($source, $request->label);

        return redirect()
            ->route('sources.edit', $source)
            ->withSuccess(__('basecore::crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\Source $source
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Source $source)
    {
        $this->authorize('delete', $source);

        $source->delete();

        return redirect()
            ->route('sources.index')
            ->withSuccess(__('basecore::crud.common.removed'));
    }
}
