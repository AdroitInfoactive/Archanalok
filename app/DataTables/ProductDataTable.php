<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
       /*  $view = '<a href="' . route('admin.products.show', $query->id) . '" class="btn btn-success btn-sm mr-1"><i
                class="fa fa-eye"></i></a>'; */
        $edit = '<a href="' . route('admin.products.edit', $query->id) . '" class="btn btn-primary btn-sm mr-1"><i
                class="fa fa-edit"></i></a>';
        $delete = '<a href="' . route('admin.products.destroy', $query->id) . '"
            class="btn btn-danger btn-sm delete-item"><i class="fa fa-trash"></i></a>';


        return '<div class="d-flex align-items-center">'  . $edit . $delete . '</div>';
        })->addColumn('status', function ($query) {
        if ($query->status == 1) {
        return '<span class="badge badge-success">Active</span>';
        } else {
        return '<span class="badge badge-danger">Inactive</span>';
        }
        })
        ->rawColumns(['action', 'status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
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
        Column::make('sku'),
        Column::make('status'),

       /*  Column::computed('action')
        ->exportable(false)
        ->printable(false)
        ->width(150)
        ->addClass('text-center'), */
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
