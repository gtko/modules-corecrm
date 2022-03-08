<div>

    <div class="flex flex-col p-5">
        <span class="ml-1">Abonnés sur le dossier :</span>
        <div class="flex flex-row space-x-1">
            <div class="w-5/6">
                <x-basecore::tom-select
                    name="follow_ids"
                    :collection="$users"
                    label="format_name"
                    id="id"
                    placeholder="Abonnés"
                    :livewire="true"
                />
            </div>
        </div>
    </div>

</div>
