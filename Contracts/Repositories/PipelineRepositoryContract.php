<?php

namespace Modules\CoreCRM\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Models\Pipeline;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface PipelineRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryQueryCustom
{
    public function create(string $name);
    public function updateName(Pipeline $pipeline, string $name);

    public function isDefault(Pipeline $pipeline);
    public function notIsDefault(Pipeline $pipeline);
}
