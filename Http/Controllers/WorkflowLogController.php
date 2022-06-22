<?php

namespace Modules\CoreCRM\Http\Controllers;

class WorkflowLogController
{
    public function index()
    {
        return view("corecrm::app.workflowlogs.index");
    }
}
