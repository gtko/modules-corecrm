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

    public function store(Request $request)
    {
        //
    }

    public function show(Workflow $workflow)
    {
        //
    }

    public function edit(Workflow $workflow)
    {
        //
    }

    public function update(Request $request, Workflow $workflow)
    {
        //
    }

    public function destroy(Workflow $workflow)
    {
        //
    }
}
