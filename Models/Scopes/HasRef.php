<?php


namespace Modules\CoreCRM\Models\Scopes;

/**
 * Trait HasRef
 * @property int $ref
 * @package Modules\CoreCRM\Models\Scopes
 */
trait HasRef
{

    abstract public static function getNumStartRef():int;

    public function getRefAttribute(): int
    {
        return $this->id + self::getNumStartRef();
    }
}
