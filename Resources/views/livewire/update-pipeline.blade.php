<x-basecore::partials.card>
    <x-slot name="title">
        <a href="{{ route('pipelines.index') }}" class="mr-4"
        ><i class="mr-1 icon ion-md-arrow-back"></i
            ></a>
    </x-slot>

    <form wire:submit.prevent="store">
        <x-basecore::inputs.group>
            <x-basecore::inputs.text
                name="name"
                label="Nom de la pipeline"
                wire:model="name"
                maxlength="255"
                required="required"
            />
        </x-basecore::inputs.group>


        <style>
            .draggable-mirror{
                background:white;
                opacity:0.6;
                box-shadow: 0 0 10px rgba(0,0,0,0.4);
                width:calc(100% - 2.5rem);
                margin:0!important;
                left:-300px!important;
                top:0px!important;
                transform-origin: center bottom;
                padding-left:0;
            }
        </style>

        <div class="my-5">

            <div class="flex justify-between items-center">
                <h2>Status de la pipeline</h2>

                <x-basecore::loading-replace wire:target="addStatus">
                    <x-slot name="loader">
                        <button class="btn btn-primary" disabled>
                            @icon('spinner', 20, 'animate-spin mr-2') Ajouter un status
                        </button>
                    </x-slot>
                    <button type="button" wire:click="addStatus" class="btn btn-primary">@icon('addCircle', 20, 'mr-2') Ajouter un status</button>
                </x-basecore::loading-replace>
            </div>

            <ul role="list" class="divide-y divide-gray-200 my-2" wire:sortable="updateStatusOrder">
                <li class="py-4 bg-gray-100">
                    <div class="grid grid-cols-12 items-center">
                        <div class="col-span-2">
                        </div>
                        <div class="col-span-6">
                            <x-basecore::inputs.group class="w-full">
                                <x-basecore::inputs.text
                                    name="new[label]"
                                    label=""
                                    wire:model="new.label"
                                    maxlength="255"
                                    required
                                />
                            </x-basecore::inputs.group>
                        </div>
                        <div class="col-span-2">
                            <div class="mt-3 overflow-hidden w-8 h-8 rounded-full bg-red-600">
                                <x-basecore::inputs.color
                                    name="new[color]"
                                    label=""
                                    wire:model="new.color"
                                    class="h-16 w-16 -mt-4 -ml-4"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                        </div>
                    </div>
                </li>
                @foreach($form as $order => $status)
                    <li class="py-4" wire:sortable.item="{{ $status['id'] }}" wire:key="status-{{ $status['id']}}">
                        <div class="grid grid-cols-12 items-center">
                            <div class="col-span-2">
                                <div wire:sortable.handle class="cursor-move">
                                    @icon('burger', null, 'mr-2')
                                </div>
                            </div>
                            <div class="col-span-6">
                                <x-basecore::inputs.group class="w-full">
                                    <x-basecore::inputs.text
                                        name="form[{{$order}}][label]"
                                        label=""
                                        wire:model="form.{{$order}}.label"
                                        maxlength="255"
                                        required="required"
                                    />
                                </x-basecore::inputs.group>
                            </div>
                            <div class="col-span-2">
                                <div class="mt-3 overflow-hidden w-8 h-8 rounded-full bg-red-600">
                                    <x-basecore::inputs.color
                                        name="status[{{$order}}][color]"
                                        label=""
                                        wire:model="status.{{$order}}.color"
                                        class="h-16 w-16 -mt-4 -ml-4"
                                        required="required"
                                    />
                                </div>
                            </div>
                            <x-basecore::loading-replace wire:target="removeStatus('{{ $status['id'] ?? ''}}')">
                                <div class="col-span-2 cursor-pointer" wire:click="removeStatus('{{ $status['id'] ?? ''}}')">
                                    @icon('delete', null, 'mr-2 hover:text-red-600')
                                </div>
                            </x-basecore::loading-replace>

                        </div>
                    </li>
                @endforeach
                <li class="py-4 bg-gray-100">
                    <div class="grid grid-cols-12 items-center">
                        <div class="col-span-2">
                        </div>
                        <div class="col-span-6">
                            <x-basecore::inputs.group class="w-full">
                                <x-basecore::inputs.text
                                    name="win['label']"
                                    label=""
                                    wire:model="win.label"
                                    maxlength="255"
                                    required
                                />
                            </x-basecore::inputs.group>
                        </div>
                        <div class="col-span-2">
                            <div class="mt-3 overflow-hidden w-8 h-8 rounded-full bg-red-600">
                                <x-basecore::inputs.color
                                    name="win['color']"
                                    label=""
                                    wire:model="win.color"
                                    class="h-16 w-16 -mt-4 -ml-4"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                        </div>
                    </div>
                </li>
                <li class="py-4 bg-gray-100">
                    <div class="grid grid-cols-12 items-center">
                        <div class="col-span-2">
                        </div>
                        <div class="col-span-6">
                            <x-basecore::inputs.group class="w-full">
                                <x-basecore::inputs.text
                                    name="lost[label]"
                                    label=""
                                    wire:model="lost.label"
                                    maxlength="255"
                                    required
                                />
                            </x-basecore::inputs.group>
                        </div>
                        <div class="col-span-2">
                            <div class="mt-3 overflow-hidden w-8 h-8 rounded-full bg-red-600">
                                <x-basecore::inputs.color
                                    name="lost[color]"
                                    label=""
                                    wire:model="lost.color"
                                    class="h-16 w-16 -mt-4 -ml-4"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-span-2">

                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="mt-5 flex justify-between items-center">
            <a href="{{ route('pipelines.index') }}" class="button">
                <i
                    class="mr-1 icon ion-md-return-left text-primary"
                ></i>
                @lang('basecore::crud.common.back')
            </a>

            <x-basecore::loading-replace wire:target="store">
                <x-slot name="loader">
                    <x-basecore::button>
                        @icon('spinner', 20, 'animate-spin mr-1')
                        @lang('basecore::crud.common.update')
                    </x-basecore::button>
                </x-slot>
                <x-basecore::button type="submit">
                    <i class="mr-1 icon ion-md-save"></i>
                    @lang('basecore::crud.common.update')
                </x-basecore::button>
            </x-basecore::loading-replace>

        </div>
    </form>

</x-basecore::partials.card>
