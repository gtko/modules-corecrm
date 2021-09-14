<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Contracts\Repositories\RelationsRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Source;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface SourceRepositoryContract extends SearchableRepository, RepositoryFetchable,RelationsRepositoryContract
{

    public function create(string $label):Source;
    public function update(Source $source, string $label):Source;

    public function getByLabel(string $label):Source;
    public function getById(int $id):Source;

}
