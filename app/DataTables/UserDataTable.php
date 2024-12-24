<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('status', function ($query) {
                $selectedActive = $query->status == 'a' ? 'selected' : '';
                $selectedPending = $query->status == 'p' ? 'selected' : '';
                $selectedPending = $query->status == 'r' ? 'selected' : '';
                $selectedPending = $query->status == 'i' ? 'selected' : '';
                return "
                    <select class='form-control status-dropdown' data-id='{$query->id}'>
                        <option value='a' {$selectedActive}>Active</option>
                        <option value='p' {$selectedPending}>Pending</option>
                        <option value='r' {$selectedPending}>Rejected</option>
                        <option value='i' {$selectedPending}>Inactive</option>
                    </select>
                ";
            })->addColumn('role', function ($query) {
                switch ($query->role) {
                    case 'user':
                        return '<span class="badge badge-primary">User</span>';
                    case 'ws':
                        return '<span class="badge badge-warning">Wholesaler</span>';
                    case 'dr':
                        return '<span class="badge badge-danger">Distributor</span>';
                    default:
                        return '<span class="badge badge-secondary">User</span>';
                }
            })
            
            ->rawColumns(['status', 'role'])
            ->setRowId('id');
    }
    

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->where('role', '!=', 'admin')->select('id', 'name', 'email', 'role', 'status')->orderBy('role', 'asc'); 
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),
            Column::make('status'),
           
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
