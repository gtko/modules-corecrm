<?php

namespace Modules\CoreCRM\Http\Livewire;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Modules\CoreCRM\Models\WorkflowLog;

class WorkflowLogDatatable extends Component implements HasTable
{
    use InteractsWithTable;

    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
    ];


    protected function getTableQuery()
    {
        return WorkflowLog::query();
    }

    protected function getTableColumns(): array
    {
        return [

            TextColumn::make('id')
                ->label('#')
                ->toggleable(true),
            TextColumn::make('flow.flowable_id')
                ->label('Dossier ID')
                ->toggleable(true),
            TextColumn::make('workflow.name')
                ->label('Workflow')
                ->toggleable(true),
            TextColumn::make('user.format_name'),
            TextColumn::make('conditions'),
            TextColumn::make('actions'),
            TextColumn::make('status'),
            TextColumn::make('message'),

        ];
    }


    protected function getTableFilters(): array
    {
        $filters = [

        ];

        return $filters;
    }

    public function render()
    {
        return view('corecrm::livewire.workflow-log-datatable');
    }

}
