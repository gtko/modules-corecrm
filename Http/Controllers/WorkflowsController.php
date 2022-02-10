<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Models\Workflow;

class WorkflowsController
{
    public function index()
    {
        $workflows = app(WorkflowRepositoryContract::class)->fetchAll();
        return view('corecrm::app.workflows.index', compact('workflows'));
    }

    public function create()
    {
        return view('corecrm::app.workflows.create');
    }

    public function edit(Workflow $workflow)
    {
        return view('corecrm::app.workflows.edit', compact('workflow'));
    }

    public function destroy(Workflow $workflow)
    {
        $workflow->delete();
        return redirect()->route('workflows.index');
    }
}
