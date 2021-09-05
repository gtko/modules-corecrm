<div>
    <form method="POST" wire:submit.prevent="store" class="mt-5">
        <x-basecore::inputs.wysiwyg name="note" label=""/>
        <x-basecore::button type="submit" class="mt-3">Save</x-basecore::button>
    </form>
</div>
