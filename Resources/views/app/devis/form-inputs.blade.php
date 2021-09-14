@php $editing = isset($devi) @endphp

<div class="flex flex-wrap flex-col">
    <div class="mb-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Détails de l'aller
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Indiquez les détails de l'aller, la date de départ, l'adresse de départ et de d'arriver.
        </p>
    </div>
    <x-basecore::partials.card>
        <div class="w-full grid grid-cols-3">
            <x-basecore::inputs.group class="w-full">
                <x-basecore::inputs.datetime label="Date de départ" name="aller_date_depart" placeholder="Date de départ"/>
            </x-basecore::inputs.group>
            <x-basecore::inputs.group class="w-full">
                <x-basecore::inputs.basic label="Point de départ" name="aller_point_depart" placeholder="Ville, adresse , ..."/>
            </x-basecore::inputs.group>
            <x-basecore::inputs.group class="w-full">
                <x-basecore::inputs.basic label="Point d'arriver" name="aller_point_arriver" placeholder="Ville, adresse , ..."/>
            </x-basecore::inputs.group>
        </div>
    </x-basecore::partials.card>

    <div class="flex flex-col mt-5 w-full">
            <x-corecrm::timeline-item>
                <x-slot name="image">
                    @icon('busStop')
                </x-slot>
                <div class="flex items-center">
                    <div class="font-medium">
                      Ville de départ
                    </div>
                    <div class="text-xs text-gray-500 ml-auto">{{Carbon\Carbon::now()->format('d/m/Y H:i')}}</div>
                </div>
            </x-corecrm::timeline-item>
            <x-corecrm::timeline-item>
                <x-slot name="image">
                    @icon('trajet')
                </x-slot>
                <div class="flex items-center">
                    <div class="font-medium">
                       Temps de trajet de 4 heures et 55 minutes pour une distance de 489 KM
                    </div>
                </div>
            </x-corecrm::timeline-item>
            <x-corecrm::timeline-item>
                <x-slot name="image">
                    @icon('busStop')
                </x-slot>
                <div class="flex items-center">
                    <div class="font-medium">
                        Adresse d'arrivé
                    </div>
                    <div class="text-xs text-gray-500 ml-auto">{{Carbon\Carbon::now()->format('d/m/Y H:i')}}</div>
                </div>
            </x-corecrm::timeline-item>
        </div>


    <div class="my-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5">
            Détails du retour
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Indiquez les détails du retour, la date de départ, l'adresse de départ et de d'arriver.
        </p>
    </div>
    <x-basecore::partials.card>
        <div class="w-full grid grid-cols-3">
        <x-basecore::inputs.group class="w-full">
            <x-basecore::inputs.datetime label="Date de départ" name="aller_date_depart" placeholder="Date de départ"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group class="w-full">
            <x-basecore::inputs.basic label="Point de départ" name="retour_point_depart" placeholder="Ville, adresse , ..."/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group class="w-full">
            <x-basecore::inputs.basic label="Point d'arriver" name="retour_point_arriver" placeholder="Ville, adresse , ..."/>
        </x-basecore::inputs.group>
    </div>
    </x-basecore::partials.card>
    <div class="flex flex-col mt-5 w-full">
        <x-corecrm::timeline-item>
            <x-slot name="image">
                @icon('busStop')
            </x-slot>
            <div class="flex items-center">
                <div class="font-medium">
                    Ville de départ
                </div>
                <div class="text-xs text-gray-500 ml-auto">{{Carbon\Carbon::now()->format('d/m/Y H:i')}}</div>
            </div>
        </x-corecrm::timeline-item>
        <x-corecrm::timeline-item>
            <x-slot name="image">
                @icon('trajet')
            </x-slot>
            <div class="flex items-center">
                <div class="font-medium">
                    Temps de trajet de 4 heures et 55 minutes pour une distance de 489 KM
                </div>
            </div>
        </x-corecrm::timeline-item>
        <x-corecrm::timeline-item>
            <x-slot name="image">
                @icon('busStop')
            </x-slot>
            <div class="flex items-center">
                <div class="font-medium">
                    Adresse d'arrivé
                </div>
                <div class="text-xs text-gray-500 ml-auto">{{Carbon\Carbon::now()->format('d/m/Y H:i')}}</div>
            </div>
        </x-corecrm::timeline-item>
    </div>


    <div class="my-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Tarifs
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Indiquez les tarifs par marques.
        </p>
    </div>
    <x-basecore::partials.card>
        <div class="grid grid-cols-3">
        <x-basecore::inputs.group>
            <x-basecore::inputs.number label="Centrale autocar" name="brand_centrale" placeholder="Tarif en €"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.number label="Location de Car" name="brand_location_car" placeholder="Tarif en €"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.number label="Mon Autocar" name="brand_mon_autocar" placeholder="Tarif en €"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group class="w-full">
            <x-basecore::inputs.checkbox
                name="tva_applicable"
                label="Tva Applicable"
                :checked="old('tva_applicable', ($editing ? $devi->tva_applicable : 0))"
            ></x-basecore::inputs.checkbox>
        </x-basecore::inputs.group>
    </div>
    </x-basecore::partials.card>

    <div class="my-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Le prix comprend
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Options inclus pour le tarif indiqué
        </p>
    </div>
    <x-basecore::partials.card>
        <div class="grid grid-cols-2">
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Repas chauffeur" name="inclus_repas_chauffeur"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Hébergement" name="inclus_hebergement"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Parking"  name="inclus_parking"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Péages"  name="inclus_peages"/>
        </x-basecore::inputs.group>
    </div>
    </x-basecore::partials.card>

    <div class="my-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Le prix ne comprend pas
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Options qui ne sont pas inclus pour le tarif indiqué
        </p>
    </div>
    <x-basecore::partials.card>
        <div class="grid grid-cols-2">
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Repas chauffeur" name="non_inclus_repas_chauffeur"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Hébergement" name="non_inclus_hebergement"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Parking"  name="non_inclus_parking"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.checkbox label="Péages"  name="non_inclus_peages"/>
        </x-basecore::inputs.group>
    </div>
    </x-basecore::partials.card>

    <div class="my-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Informations
        </h3>
        <p class="mt-1 text-sm text-gray-500">
           informations divers sur les trajets en bus
        </p>
    </div>
    <x-basecore::partials.card>
        <div class="grid grid-cols-2">
        <x-basecore::inputs.group>
            <x-basecore::inputs.basic label="Adresse de ramassage"  name="addresse_ramassage"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.basic label="Adresse de destination"  name="addresse_destination"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.basic label="N° de tel chauffeur Aller"  name="aller_tel_chauffeur"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.basic label="N° de tel chauffeur Retour"  name="retour_tel_chauffeur"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.number label="Nombres de cars"  name="nombre_bus"/>
        </x-basecore::inputs.group>
        <x-basecore::inputs.group>
            <x-basecore::inputs.number label="Nombre de chauffeurs"  name="nombre_chauffeur"/>
        </x-basecore::inputs.group>
    </div>
    </x-basecore::partials.card>

    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.textarea name="data" label="Data" maxlength="255" required
        >{{ old('data', ($editing ? json_encode($devi->data) : ''))
            }}</x-basecore::inputs.textarea
        >
    </x-basecore::inputs.group>

    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.select name="fournisseur_id" label="Fournisseur">
            @php $selected = old('fournisseur_id', ($editing ? $devi->fournisseur_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the fournisseur</option>
            @foreach($fournisseurs as $fournisseur)
            <option value="{{ $fournisseur->id }}" {{ $selected == $fournisseur->id ? 'selected' : '' }} >{{ $fournisseur->format_name }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </x-basecore::inputs.group>
</div>
