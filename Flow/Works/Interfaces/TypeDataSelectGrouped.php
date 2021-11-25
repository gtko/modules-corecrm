<?php

namespace Modules\CoreCRM\Flow\Works\Interfaces;

interface TypeDataSelectGrouped extends TypeDataSelect
{
    public function isGrouped():bool;
    public function getFieldGroupeName($option):string;
    public function getFieldGroupeValue($option):array;
}
