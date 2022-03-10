<div>

    <div class="flex flex-col p-5">
        @if($label)
            <span class="ml-1">Abonné{{($tomselect)?'s':''}} sur le dossier :</span>
        @endif
        <div class="flex flex-row space-x-1">
            <div class="w-5/6">
                @if($tomselect)
                <x-basecore::tom-select
                    name="follow_ids"
                    :collection="$users"
                    label="format_name"
                    id="id"
                    placeholder="Abonnés"
                    :livewire="true"
                />
                @else
                    <select wire:model="follow_ids">
                        <option value="0">Aucun</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->format_name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>

</div>
