<?php

namespace Modules\CoreCRM\Flow\Works\Params;

use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelectGrouped;

class ParamsStatus extends WorkFlowParams implements TypeDataSelectGrouped
{


    public function name(): string
    {
        return 'Status';
    }

    public function describe(): string
    {
        return "choissisez le status";
    }

    public function getOptions(): array
    {
        $pipeline = app(PipelineRepositoryContract::class);
        return $pipeline->newQuery()->with('statuses')->get()->toArray();
    }

    public function getFieldValue($option): string
    {
        return $option["id"];
    }

    public function getFieldLabel($option): string
    {
        return $option["label"];
    }

    public function isGrouped(): bool
    {
        return true;
    }

    public function getFieldGroupeName($option): string
    {
       return $option['name'];
    }

    public function getFieldGroupeValue($option): array
    {
        return $option['statuses'];
    }

    public function getValue()
    {
        $statusRep = app(StatusRepositoryContract::class);
        return $statusRep->fetchById($this->value);
    }

    function nameView(): string
    {
        return "corecrm::workflows.select-grouped";
    }
}
