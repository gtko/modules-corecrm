<?php

namespace Modules\CoreCRM\Flow\Works\Interfaces;

interface TypeDataSelect
{
    public function getOptions():array;
    public function getFieldValue($option):string;
    public function getFieldLabel($option): string;
}
