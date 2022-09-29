<div>

    @if($state == 'wait')
        <div>

            <div class="mb-2 bg-white shadow bg-white p-2">
                Tester le workflow shedule sur tous les dossiers (non blanc et non terminé ou clôturé).<br>
                La simulation prend autant de temps qu'il y a de dossier en moyenne moins de 20s. <br>
                Ce temps peut monter jusqu'a plus de 1 minuets.<br>

                <span class="text-red-600 mt-2">Aucun dossier n'est modifié, la simulation est uniquement consultable.</span>
            </div>

            <div class="btn btn-primary" wire:click="launchSimulate">Lancer la simulation</div>

        </div>

    @elseif($state == 'processing')
        <div class="p-5">
           <div class="flex justify-start items-center">
               @icon('spinner', 25, 'animate-spin mr-2') <div>Simulation en cours sur tous les dossiers (non blanc et non terminé ou clôturé).</div>
            </div>
            <div class="text-sm text-gray-600">
                ** peut prendre jusqu'a 1 minutes
            </div>
        </div>
    @elseif($state == 'done')

        <div class="mb-5 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <div class="p-2 bg-green-500 text-white rounded">
                 {{$runnables->where('execute', true)->count()}} dossiers affectés.
            </div>
            <div class="p-2 bg-red-500 text-white rounded">
                {{$runnables->where('execute', false)->count()}} dossiers non affectés.
            </div>
        </div>

        <h2 class="mt-4 mb-2 text-lg  text-green-500 font-bold">Dossiers affectés</h2>
        <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-4">
            @foreach($runnables->where('execute', true) as $run)
                <div class="p-2 shadow bg-white rounded" key="{{($run['dossier']->ref.$run['devis']->ref)}}">
                    <div class="w-full flex justify-between items-center">
                        <a target="_blank" href="{{route('dossiers.show', [$run['dossier']->client, $run['dossier']])}}">Dossier#{{$run['dossier']->ref}} - Devis#{{$run['devis']->ref}}</a>
                        @if($run['execute'])
                            @icon('checkCircle',null, 'text-green-500')
                        @else
                            @icon('noIcon', null, 'text-red-500')
                        @endif
                    </div>
                    <div x-data="{open:false}" class="mt-2">
                        <span class="btn btn-sm btn-primary" x-on:click="open=!open">Voir les logs</span>
                        <div [x-cloak]  x-show="open" class="text-sm text-gray-500 py-4">
                            @foreach($run['log'] as $log)
                                <div class="text-overflow whitespace-nowrap">{{$log}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h2 class="mt-4 mb-2 text-lg text-red-500 font-bold">Dossier non affectés</h2>
        <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-4">
            @foreach($runnables->where('execute', false) as $run)
                <div class="p-2 shadow bg-white rounded" key="{{($run['dossier']->ref.$run['devis']->ref)}}">
                    <div class="w-full flex justify-between items-center">
                        <a target="_blank" href="{{route('dossiers.show', [$run['dossier']->client, $run['dossier']])}}">Dossier#{{$run['dossier']->ref}} - Devis#{{$run['devis']->ref}}</a>
                        @if($run['execute'])
                            @icon('checkCircle',null, 'text-green-500')
                        @else
                            @icon('noIcon', null, 'text-red-500')
                        @endif
                    </div>
                    <div x-data="{open:false}" class="mt-2">
                        <span class="btn btn-sm btn-primary" x-on:click="open=!open">Voir les logs</span>
                        <div [x-cloak]  x-show="open" class="text-sm text-gray-500 py-4">
                            @foreach($run['log'] as $log)
                                <div class="text-overflow whitespace-nowrap">{{$log}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
