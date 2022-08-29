<?php

namespace Modules\CoreCRM\Http\Livewire;


use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Modules\CoreCRM\Models\Workflow;
use Modules\CoreCRM\Models\WorkflowLog;

class WorkflowDatatable extends Component implements HasTable
{
    use InteractsWithTable;

    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
    ];

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableQuery()
    {
        return Workflow::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('#')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            TextColumn::make('name')
                ->label('Workflow')
                ->searchable()
                ->toggleable(true),
            ViewColumn::make('class')->view('crmautocar::filament.tables.columns.class'),
            ViewColumn::make('active')->view('crmautocar::filament.tables.columns.status-switcher')
        ];
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn(Model $record): string => route('workflows.edit', [$record]);
    }

    protected function getTableFilters(): array
    {
        $filters = [

        ];

        return $filters;
    }

    public function render()
    {
        return view('corecrm::livewire.workflow-datatable');
    }

}
