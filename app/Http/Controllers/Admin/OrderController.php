<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $query = Order::query();
        $query->when($request->filled('customer'), function ($q) use ($request) {
            $q->where('customer_name', 'like', '%' . $request->customer . '%');
        });

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $orders = $query->latest()->paginate(10);

        $orders->appends($request->all());

        return view('admin.orders.list', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderDetails.product');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == Order::STATUS_CANCEL) {
            return back()->with('error', 'Order has been canceled and cannot be updated.');
        }

        $request->validate([
            'status' => 'required|integer|in:0,1,2,3',
        ]);

        DB::beginTransaction();

        try {
            if ($request->status == Order::STATUS_CANCEL && $order->status != Order::STATUS_CANCEL) {

                $order->load('orderDetails.product');

                foreach ($order->orderDetails as $detail) {
                    if ($detail->product) {
                        $product = $detail->product;

                        $product->stock = $product->stock + $detail->quantity;
                        $product->save();
                    }
                }
            }

            $order->status = $request->status;
            $order->save();

            DB::commit();
            return back()->with('success', 'Order status updated and stock successfully synchronized!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating order: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
{
    $query = Order::query();

    if ($request->filled('id')) {
        $query->where('id', $request->id);
    }

    if ($request->filled('customer_name')) {
        $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
    }

    if ($request->filled('phone')) {
        $query->where('phone', 'like', '%' . $request->phone . '%');
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    $orders = $query->latest()->paginate(10);

    return view('admin.orders.list', compact('orders'));
}
}