<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Http\Requests\StatusStoreRequest;
use Modules\CoreCRM\Http\Requests\StatusUpdateRequest;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;

class StatusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request): Application|Factory|View
    {
        $this->authorize('views-any', Status::class);

        return view('corecrm::app.statuses.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request): View|Factory|Application
    {
        $this->authorize('create', Status::class);

        return view('corecrm::app.statuses.create');
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\StatusStoreRequest $request
     * @param \Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract $statusRep
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StatusStoreRequest $request, StatusRepositoryContract $statusRep): RedirectResponse
    {
        $this->authorize('create', Status::class);

        $pipeline = Pipeline::first();
        if(!$pipeline){
            $pipeline = new Pipeline();
            $pipeline->name = 'Default';
            $pipeline->save();
        }

        $status = $statusRep->create($pipeline, $request->label, $request->color, 1, StatusTypeEnum::TYPE_CUSTOM);

        return redirect()
            ->route('statuses.edit', $status)
            ->withSuccess(__('basecore::crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\Status $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Status $status): View|Factory|Application
    {
        $this->authorize('views', $status);

        return view('corecrm::app.statuses.show', compact('status'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\Status $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, Status $status): Application|Factory|View
    {
        $this->authorize('update', $status);

        return view('corecrm::app.statuses.edit', compact('status'));
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\StatusUpdateRequest $request
     * @param \Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract $statusRep
     * @param \Modules\CoreCRM\Models\Status $status
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StatusUpdateRequest $request, StatusRepositoryContract $statusRep, Status $status): RedirectResponse
    {
        $this->authorize('update', $status);

        $statusRep->update($status, $request->label, $request->color);

        return redirect()
            ->route('statuses.edit', $status)
            ->withSuccess(__('basecore::crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\Status $status
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Status $status): RedirectResponse
    {
        $this->authorize('delete', $status);

        $status->delete();

        return redirect()
            ->route('statuses.index')
            ->withSuccess(__('basecore::crud.common.removed'));
    }
}
