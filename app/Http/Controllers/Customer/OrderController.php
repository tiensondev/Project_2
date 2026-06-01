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

        $cart = Cart::where('user_id', $userId)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'phone'          => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'province'       => 'required|string',
            'district'       => 'required|string',
            'ward'           => 'required|string',
            'address_detail' => 'required|string|min:5|max:255',
        ], [
            'phone.required'          => 'Please write your phone number.',
            'phone.regex'             => 'Incorrect phone number format.',
            'phone.min'               => 'Phone number must be at least 10 digits.',
            'province.required'       => 'Please select your province/city.',
            'district.required'       => 'Please select your district.',
            'ward.required'           => 'Please select your ward/commune.',
            'address_detail.required' => 'Please write your specific address detail.',
            'address_detail.min'      => 'Specific address detail must be at least 5 characters.',
        ]);

        DB::beginTransaction();

        try {
            $totalMoney = 0;

            foreach ($cart->items as $item) {
                $product = $item->product;

                if (!$product || $product->stock <= 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Product "' . ($product->name ?? 'Unknown') . '" is out of stock. Please remove it from your cart.');
                }

                if ($item->quantity > $product->stock) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Product "' . $product->name . '" does not have enough quantity in stock (Available: ' . $product->stock . ')');
                }

                $totalMoney += $product->price * $item->quantity;
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
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                $product = $item->product;
                $product->stock = $product->stock - $item->quantity;
                $product->save();
            }

            $cart->items()->delete();

            DB::commit();

            return redirect()->route('cart.index')->with('success', 'Order placed successfully! Your order is being processed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the payment: ' . $e->getMessage());
        }
    }

    public function index()
    {   
        $user = Auth::user();
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('order', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->with('orderDetails.product')->firstOrFail();
        return view('order_detail', compact('order'));
    }
}