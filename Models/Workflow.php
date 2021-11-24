<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property array $events
 * @property array $conditions
 * @property array $actions
 * @property bool $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Workflow extends Model
{

    protected $fillable = [
        'name', 'description', 'events', 'conditions', 'actions', 'active'
    ];

    protected $casts = [
        'events' => 'array',
        'conditions' => 'array',
        'actions' => 'array'
    ];

}
