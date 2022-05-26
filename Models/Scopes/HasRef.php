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
    public static function getPrefixRef(){
        return '';
    }



    public function getRefAttribute(): string
    {
        return $this->getPrefixRef() . ($this->id + self::getNumStartRef());
    }
}
