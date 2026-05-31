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

    public function destroy(Order $order)
    {
        DB::beginTransaction();

        try {
            $order->load('orderDetails.product');

            if ($order->status != Order::STATUS_CANCEL) {
                foreach ($order->orderDetails as $detail) {
                    if ($detail->product) {
                        $product = $detail->product;
                        $product->stock = $product->stock + $detail->quantity;
                        $product->save();
                    }
                }
            }

            $order->orderDetails()->delete();

            $order->delete();

            DB::commit();

            return redirect()
                ->route('admin.orders.index')
                ->with('success', 'Order and its details deleted, stock updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.orders.index')
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }
}