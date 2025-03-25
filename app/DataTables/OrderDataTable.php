<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    protected $status;

    public function with(array|string $key, mixed $value = null): static
    {
        if ($key === 'status') {
            $this->status = $value;
        }
        return $this;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_name', fn($query) => $query->user?->name)
            ->addColumn('grand_total', fn($query) => $query->grand_total . ' ' . strtoupper($query->currency_name))
            ->addColumn('order_status', function ($query) {
                $statusLabels = [
                    'Pending' => ['label' => 'Pending', 'color' => 'warning'],
                    'Placed' => ['label' => 'Placed', 'color' => 'info'],
                    'Payment Received' => ['label' => 'Payment Received', 'color' => 'primary'],
                    'Shipped' => ['label' => 'Shipped', 'color' => 'secondary'],
                    'Delivered' => ['label' => 'Delivered', 'color' => 'success'],
                    'Cancelled' => ['label' => 'Cancelled', 'color' => 'danger'],
                    'Returned' => ['label' => 'Returned', 'color' => 'dark'],
                ];
                $status = $query->order_status;
                $labelInfo = $statusLabels[$status] ?? ['label' => ucfirst($status), 'color' => 'dark'];
                return '<span class="badge badge-' . $labelInfo['color'] . '">' . $labelInfo['label'] . '</span>';
            })
            ->addColumn('payment_status', function ($query) {
                if ($query->payment_status == 1) {
                    return '<span class="badge badge-success">Completed</span>';
                } elseif ($query->payment_status == 0) {
                    return '<span class="badge badge-warning">Pending</span>';
                } else {
                    return '<span class="badge badge-danger">' . $query->payment_status . '</span>';
                }
            })
            ->editColumn('created_at', fn($query) => $query->created_at->format('d-m-Y'))
            ->addColumn('action', function ($query) {
                $view = "<a href='" . route('orders.show', $query->id) . "' class='btn btn-primary'><i class='fas fa-eye'></i></a>";
                $status = "<a href='javascript:;' class='btn btn-warning ml-2 order_status_btn' data-id='" . $query->id . "'><i class='fas fa-truck-loading' data-toggle='modal' data-target='#order_modal'></i></a>";
                $delete = "<a href='" . route('orders.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash'></i></a>";
                return $view . $status . $delete;
            })
            ->addColumn('invoice_id', function ($query) {
                return ($query->payment_status == 1)
                    ? 'ATC/' . $query->financial_year . '/' . str_pad($query->id, 3, '0', STR_PAD_LEFT)
                    : $query->temp_invoice_id;
            })
            ->rawColumns(['order_status', 'payment_status', 'action', 'invoice_id'])
            ->setRowId('id');
    }

    public function query(Order $model): QueryBuilder
    {
        $query = $model->newQuery();
        if ($this->status) {
            if ($this->status === 'Payment Pending') {
                $query->where('payment_status', 0);
            } elseif (!empty($this->status)) {
                $query->where('order_status', $this->status);
            }
        }
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('order-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(7, 'desc')
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

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('invoice_id'),
            Column::make('user_name'),
            Column::make('quantity'),
            Column::make('grand_total'),
            Column::make('order_status'),
            Column::make('payment_status'),
            Column::make('created_at')->title('Order Date'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Order_' . date('YmdHis');
    }
}
