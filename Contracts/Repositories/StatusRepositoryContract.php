<?php


namespace Modules\CoreCRM\Contracts\Repositories;


use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Status;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface StatusRepositoryContract extends SearchableRepository, RepositoryFetchable
{

    public function create(string $label, string $color):Status;
    public function update(Status $status, string $label, string $color):Status;

    public function existByLabel(string $label):bool;
    public function findByLabel(string $label):?Status;
    public function getById(int $id):Status;

}
