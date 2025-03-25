<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Pending']) }}"
            class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-hourglass-start"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pending</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->pending_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Placed']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Placed</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->placed_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Payment Received']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Payment Received</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->payment_received_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Shipped']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-secondary">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Shipped</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->shipped_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Delivered']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Delivered</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->delivered_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Cancelled']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Cancelled</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->cancelled_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Returned']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Returned</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->returned_count }}</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index', ['status' => 'Payment Pending']) }}" class="text-decoration-none text-dark">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Payment Pending</h4>
                    </div>
                    <div class="card-body">{{ $orderStats->payment_pending_count }}</div>
                </div>
            </div>
        </a>
    </div>
</div>
