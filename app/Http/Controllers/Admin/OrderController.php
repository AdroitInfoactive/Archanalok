<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderDataTable $dataTable)
    {
        $status = request()->get('status');
        $orderStats = DB::selectOne("
            SELECT
                COUNT(*) AS total_orders,
                IFNULL(SUM(CASE WHEN order_status = 'Pending' THEN 1 ELSE 0 END), 0) AS pending_count,
                IFNULL(SUM(CASE WHEN order_status = 'Placed' THEN 1 ELSE 0 END), 0) AS placed_count,
                IFNULL(SUM(CASE WHEN order_status = 'Payment Received' THEN 1 ELSE 0 END), 0) AS payment_received_count,
                IFNULL(SUM(CASE WHEN order_status = 'Shipped' THEN 1 ELSE 0 END), 0) AS shipped_count,
                IFNULL(SUM(CASE WHEN order_status = 'Delivered' THEN 1 ELSE 0 END), 0) AS delivered_count,
                IFNULL(SUM(CASE WHEN order_status = 'Cancelled' THEN 1 ELSE 0 END), 0) AS cancelled_count,
                IFNULL(SUM(CASE WHEN order_status = 'Returned' THEN 1 ELSE 0 END), 0) AS returned_count,
                IFNULL(SUM(CASE WHEN payment_status = 0 THEN 1 ELSE 0 END), 0) AS payment_pending_count
            FROM orders;
        ");
        return $dataTable->with('status', $status)->render('admin.order.index', compact('orderStats', 'status'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    function getOrderStatus(string $id)
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

        return response($order);
    }

    function orderStatusUpdate(Request $request, string $id)
    {
        $request->validate([
            'payment_status' => ['required', 'in:0,1'],
            'order_status' => ['required', 'in:Pending,Placed,Payment Received,Shipped,Delivered,Cancelled,Returned']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if ($request->ajax()) {
            return response(['message' => 'Order Status Updated!']);
        } else {
            toastr()->success('Status Updated Successfully!');

            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
