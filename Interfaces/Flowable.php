<?php


namespace Modules\CoreCRM\Interfaces;


use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Flowable
{

    public function flow():MorphMany;

}
