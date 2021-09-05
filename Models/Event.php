<?php

namespace Modules\CoreCRM\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Event
 * @property string $key
 * @property Collection $flows
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models
 */
class Event extends Model
{

    public function flows():HasMany
    {
        return $this->hasMany(Flow::class);
    }

}
