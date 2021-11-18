@php $editing = isset($status) @endphp

<div class="flex flex-wrap">
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.text
            name="label"
            label="Label"
            value="{{ old('label', ($editing ? $status->label : '')) }}"
            maxlength="255"
            required
        ></x-basecore::inputs.text>
    </x-basecore::inputs.group>
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.color
            name="color"
            label="Color"
            value="{{ old('color', ($editing ? $status->color : '')) }}"
            maxlength="255"
            required
        ></x-basecore::inputs.color>
    </x-basecore::inputs.group>


    // IGI la possibilité de configurer des events

    // 2 - status de base (En attente, Terminer) Départ / arrivé

    // 3 - il y a des matrice d'état


</div>
