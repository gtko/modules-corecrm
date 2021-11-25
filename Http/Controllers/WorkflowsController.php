<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreCRM\Models\Workflow;

class WorkflowsController
{
    public function index()
    {
        return view('corecrm::app.workflows.index');
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
