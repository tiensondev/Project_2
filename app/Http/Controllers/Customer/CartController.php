<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in to add items to your cart.');
        }

        $userId = Auth::id();

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

public function updateCart(Request $request)
{
    $cartItemId = $request->input('id');
    $quantity = $request->input('quantity');

    $cartItem = CartItem::find($cartItemId);

    if ($cartItem && $cartItem->cart->user_id == Auth::id()) {

        if ($quantity > 0) {

            $cartItem->update([
                'quantity' => $quantity
            ]);

            return redirect()->back()
                ->with('success', 'Cart updated successfully!');
        }

        $cartItem->delete();
        return redirect()->back()
            ->with('success', 'Product removed from cart successfully!');
    }

    return redirect()->back()
        ->with('error', 'Cart item not found.');
}

    public function removeFromCart(Request $request)
    {
        $cartItemId = $request->input('id'); 

        $cartItem = CartItem::find($cartItemId);

        if ($cartItem && $cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();

            session()->flash('success', 'Product removed from cart successfully!');

            return redirect()->back()->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->back()->with('error', 'Product not found or unauthorized.');
    }

    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        $cartItems = $cart ? $cart->items : collect();

        return view('cart', compact('cartItems'));
    }
}
