<div>
    <div class="mb-2 grid-cols-2 grid gap-2">
        <div class="col-span-2">
            <x-corecrm::status :label="$dossier->status_label" :color="$dossier->status_color" />
        </div>
        <select class="form-select form-select-sm" aria-label=".form-select-sm example" wire:model.defer="statusSelect">
            <option selected value="">Status</option>
            @foreach($statusList as $statu)
                <option value="{{$statu->id}}">{{$statu->label}}</option>
            @endforeach
        </select>
        <div class="btn btn-primary py-0 px-2" wire:click="change()">Change</div>
    </div>
</div>
