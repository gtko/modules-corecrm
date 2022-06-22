<?php

namespace Modules\CoreCRM\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Contracts\Entities\UserEntity;

/**
 * Class WorkflowLog
 * @property int $id
 * @property int $flow_id
 * @property int $workflow_id
 * @property int $user_id
 * @property array $data
 * @property \Modules\CoreCRM\Models\Flow $flow
 * @property \Modules\CoreCRM\Models\Workflow $workflow
 * @property \Modules\BaseCore\Contracts\Entities\UserEntity $user
 *
 * @package Modules\CoreCRM\Models
 */
class WorkflowLog extends Model
{


    protected $fillable = [
        'flow_id',
        'workflow_id',
        'user_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function user()
    {
        return $this->belongsTo(app(UserEntity::class)::class);
    }
}
