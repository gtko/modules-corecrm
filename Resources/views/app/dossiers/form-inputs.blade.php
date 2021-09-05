@php $editing = isset($dossier) @endphp

<div class="flex flex-wrap">
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.select name="commercial_id" label="Commercial" required="required">
            @php $selected = old('commercial_id', ($editing ? $dossier->commercial_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Choisissez un commercial</option>
            @foreach($commercials as $commercial)
            <option value="{{ $commercial->id}}" {{ $selected === $commercial->id ? 'selected' : '' }} >{{ $commercial->formatName }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </x-basecore::inputs.group>

    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.select name="status_id" label="Status" required="required">
            @php $selected = old('status_id', ($editing ? $dossier->status_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Choisissez un status</option>
            @foreach($status as $statu)
                <option value="{{ $statu->id}}" {{ $selected === $statu->id ? 'selected' : '' }} >{{ $statu->label }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </x-basecore::inputs.group>
</div>
