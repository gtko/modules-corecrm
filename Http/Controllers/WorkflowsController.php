<?php

namespace Modules\CoreCRM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreCRM\Actions\workflow\PrepareActivesWorkflow;
use Modules\CoreCRM\Actions\workflow\RunDossierByWorkflow;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Events\FlowAddEvent;
use Modules\CoreCRM\Flow\Attributes\SheduleAttribute;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Models\Flow;
use Modules\CoreCRM\Models\Workflow;
use Modules\CrmAutoCar\Models\Dossier;

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

    public function simulate(Workflow $workflow){


        return view('corecrm::app.workflows.simulate', compact('workflow'));
    }

}
