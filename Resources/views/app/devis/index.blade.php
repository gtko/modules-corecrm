<x-basecore::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.devis.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-basecore::partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-basecore::inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('basecore::crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-basecore::inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', Modules\CoreCRM\Contracts\Entities\DevisEntities::class)
                            <a
                                href="{{ route('devis.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('basecore::crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.devis.inputs.dossier_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.devis.inputs.commercial_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.devis.inputs.data')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.devis.inputs.tva_applicable')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.devis.inputs.fournisseur_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($devis as $devi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional($devi->dossier)->date_start ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($devi->commercial)->password ??
                                    '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($devi->data) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $devi->tva_applicable ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($devi->fournisseur)->password ??
                                    '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $devi)
                                        <a
                                            href="{{ route('devis.edit', $devi) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('views', $devi)
                                        <a
                                            href="{{ route('devis.show', $devi) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $devi)
                                        <form
                                            action="{{ route('devis.destroy', $devi) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('basecore::crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    @lang('basecore::crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="mt-10 px-4">
                                        {!! $devis->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-basecore::partials.card>
        </div>
    </div>
</x-basecore::app-layout>
