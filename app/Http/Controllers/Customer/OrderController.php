<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
            ->with(['items.product', 'items.productDetail'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'phone'          => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'province'       => 'required|string',
            'district'       => 'required|string',
            'ward'           => 'required|string',
            'address_detail' => 'required|string|min:5|max:255',
        ]);

        DB::beginTransaction();

        try {
            $totalMoney = 0;

            foreach ($cart->items as $item) {
                $product = $item->product;
                $detail = $item->productDetail;

                if (!$product || !$detail) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Cart item is invalid.');
                }

                if ($detail->stock <= 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Product "' . $product->name . '" is out of stock.');
                }

                if ($item->quantity > $detail->stock) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Product "' . $product->name . '" does not have enough stock. Available: ' . $detail->stock);
                }

                $totalMoney += $detail->price * $item->quantity;
            }

            $order = Order::create([
                'user_id'        => $userId,
                'customer_name'  => Auth::user()->name,
                'phone'          => $request->phone,
                'province'       => $request->province,
                'district'       => $request->district,
                'ward'           => $request->ward,
                'address_detail' => $request->address_detail,
                'total'          => $totalMoney,
                'status'         => '1',
            ]);

            foreach ($cart->items as $item) {
                $detail = $item->productDetail;

                OrderDetail::create([
                    'order_id'          => $order->id,
                    'product_id'        => $item->product_id,
                    'product_detail_id' => $item->product_detail_id,
                    'quantity'          => $item->quantity,
                    'price'             => $item->productDetail->price,
                ]);

                $detail->stock -= $item->quantity;
                $detail->save();
            }

            $cart->items()->delete();

            DB::commit();

            return redirect()
                ->route('cart.index')
                ->with('success', 'Order placed successfully! Your order is being processed.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'An error occurred while processing the payment: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['orderDetails.product', 'orderDetails.productDetail'])
            ->firstOrFail();

        return view('order_detail', compact('order'));
    }
}
