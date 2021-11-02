<div>
    <div style="background-color: {{ $dossier->status->color }}" class="rounded-3 rounded text-white pl-2">
        {{$dossier->status->label ?? ''}}
    </div>
    <div class="mb-2 grid-cols-2 grid gap-2">
        <select class="form-select form-select-sm mt-2" aria-label=".form-select-sm example" wire:model="statusSelect">
            <option selected value="">Status</option>
            @foreach($statusList as $statu)
                <option value="{{$statu->id}}">{{$statu->label}}</option>
            @endforeach
        </select>
        <div class="px-4 py-1 rounded bg-blue-600 text-white text-sm mt-2 cursor-pointer" wire:click="change()">Change</div>
    </div>





</div>

