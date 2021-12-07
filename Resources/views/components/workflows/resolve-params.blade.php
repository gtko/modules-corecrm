@props([
   'param',
   'model'
])

@if($param instanceof Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelectGrouped)
    <x-corecrm::workflows.select-grouped :param="$param" :model="$model"/>
@elseif($param instanceof Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelect)
    <x-corecrm::workflows.select :param="$param" :model="$model"/>
@elseif($param instanceof Modules\CoreCRM\Flow\Works\Params\ParamsNumber)
    <x-corecrm::workflows.number :param="$param" :model="$model"/>
@elseif($param instanceof Modules\CoreCRM\Flow\Works\Params\ParamsNotification)
    <x-corecrm::workflows.notification :param="$param" :model="$model"/>
@else
    <x-basecore::inputs.group>
        <x-basecore::inputs.textarea
            name="name"
            label="{{$param->name()}}"
            wire:model="{{$model}}"
            required="required"
        />
    </x-basecore::inputs.group>
@endif
