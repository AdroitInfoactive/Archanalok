<?php

namespace App\DataTables;

use App\Models\VariantDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VariantDetailDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($query) {
           
            $edit = '<a href="' . route('admin.variant-details.edit', $query->id) . '" class="btn btn-primary btn-sm ml-2 mr-2"><i class="fa fa-edit"></i></a>';
            $delete = '<a href="' . route('admin.variant-details.destroy', $query->id) . '" class="btn btn-danger delete-item btn-sm "><i class="fa fa-trash"></i></a>';
            return  $edit . $delete;
        })->addColumn('status', function ($query) {
            if ($query->status == 1) {
                return '<span class="badge badge-success">Active</span>';
            } else {
                return '<span class="badge badge-danger">Inactive</span>';
            }
        })->addColumn('variant_master', function ($query) {
            if ($query->variant_master_id != null) {
                return $query->variantMaster->name;
            }
        })
        ->rawColumns(['action', 'status', 'image'])
        ->setRowId('id');
    }
    

    /**
     * Get the query source of dataTable.
     */
    public function query(VariantDetail $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('variantdetail-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::make(data: 'variant_master'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VariantDetail_' . date('YmdHis');
    }
}
