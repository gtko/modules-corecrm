<?php

namespace Modules\CoreCRM\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Models\Workflow;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface WorkflowRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryQueryCustom
{

    public function create(string $name, string $description = '', array $events = [], array $conditions = [], array $actions = [], bool $active = false):Workflow;
    public function update(Workflow $workflow,string $name, string $description = '', array $events = [], array $conditions = [], array $actions = [], bool $active = false):Workflow;

    public function updateEvents(Workflow $workflow, array $events):Workflow;
    public function updateConditions(Workflow $workflow, array $conditions):Workflow;
    public function updateActions(Workflow $workflow, array $actions):Workflow;

    public function activate(Workflow $workflow):Workflow;
    public function desactivate(Workflow $workflow):Workflow;

}
