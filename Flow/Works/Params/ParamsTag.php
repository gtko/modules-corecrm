<?php

namespace Modules\CoreCRM\Flow\Works\Params;

use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelect;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class ParamsTag extends WorkFlowParams implements TypeDataSelect
{


    public function name(): string
    {
        return 'Tags';
    }

    public function describe(): string
    {
        return "choissisez un tag";
    }

    public function getOptions(): array
    {
        $tags = app(TagsRepositoryContract::class);
        return $tags->newQuery()->get()->toArray();
    }

    public function getFieldValue($option): string
    {
        return $option["id"];
    }

    public function getFieldLabel($option): string
    {
        return $option["label"];
    }

    public function getValue()
    {
        $tag = app(TagsRepositoryContract::class);
        return $tag->fetchById($this->value);
    }

    function nameView(): string
    {
        return "corecrm::workflows.select";
    }
}
