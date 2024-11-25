<?php

namespace App\DataTables;

use App\Models\MainCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MainCategoryDataTable extends DataTable
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
            $view = '<a href="' . route('admin.main-category.show', $query->id) . '" class="btn btn-success btn-sm mr-1"><i class="fa fa-eye"></i></a>';
            $edit = '<a href="' . route('admin.main-category.edit', $query->id) . '" class="btn btn-primary btn-sm mr-1"><i class="fa fa-edit"></i></a>';
            $delete = '<a href="' . route('admin.main-category.destroy', $query->id) . '" class="btn btn-danger btn-sm delete-item"><i class="fa fa-trash"></i></a>';
            
            $more = '<div class="btn-group dropleft ml-1">
                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('admin.main-category-banner.show', $query->id) . '">Banners</a>
                        </div>
                     </div>';
            return '<div class="d-flex align-items-center">' . $view . $edit . $delete . $more . '</div>';
        })->addColumn('status', function ($query) {
            if ($query->status == 1) {
                return '<span class="badge badge-success">Active</span>';
            } else {
                return '<span class="badge badge-danger">Inactive</span>';
            }
        })->addColumn('logo', function ($query) {
            if ($query->logo != null) {
                return '<img src="' . asset( $query->logo) . '" width="100px">';
            }
        })
        ->rawColumns(['action', 'status', 'logo'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MainCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('maincategory-table')
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
            Column::make('logo'),
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
        return 'MainCategory_' . date('YmdHis');
    }
}
