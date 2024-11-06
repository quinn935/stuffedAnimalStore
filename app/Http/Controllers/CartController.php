<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index(){
        $cartItems = Cart::getCartItems();
        $ids = Arr::pluck($cartItems, 'product_id');//$ids = [101,102,103]
        $products = Product::query()->whereIn('id', $ids)->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');
           //$cartItems = [
//     101 => ['product_id' => 101, 'quantity' => 2],
//     102 => ['product_id' => 102, 'quantity' => 1],
//     103 => ['product_id' => 103, 'quantity' => 4],
// ];

        if(!empty($cartItems)){
            foreach($products as $product){
                $total = $product->price * $cartItems[$product->id]['quantity'];
            }
        }else{
            $total = 0;
        }

        return view('cart.index', compact('cartItems', 'products', 'total'));

    }


    public function add(Request $request, Product $product){
        $quantity = (int)$request->post('quantity', 1);
        $user = $request->user();
        if($user){
            $cartItem = CartItem::where(['user_id'=>$user->id, 'product_id'=>$product->id])->first();
            if($cartItem){
                $cartItem->quantity += $quantity;
                $cartItem->update();
            }else{
                $data = [
                    'user_id' => $user->id,
                    'product_id' =>$product->id,
                    'quantity' => $quantity
                ];
                CartItem::create($data);
            }


            return response(['count'=>Cart::getCartItemsCount()]);

        }else{
            $cartItems = Cart::getCookieCartItems();
            $productFound = false;
            foreach($cartItems as &$item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }


            if(!$productFound){
                $cartItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);

            return response(['count'=>Cart::getCountFromItems($cartItems)]);

        }

    }

    public function removeItemFromCart(Request $request, Product $product){
        $user = $request->user();
        if($user){
            $cartItem = CartItem::where(['user_id'=>$user->id, 'product_id'=>$product->id])->first();
            if($cartItem){
                $cartItem->delete();
            }
            return response(['count'=>Cart::getCartItemsCount()]);
        }else{
            $cartItems = Cart::getCookieCartItems();
            foreach($cartItems as $i=>&$cartItem){
                if($cartItem['product_id'] == $product->id){
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);

            return response(['count'=>Cart::getCountFromItems($cartItems)]);
        }
    }


    public function updateQuantity(Request $request, Product $product){
        $quantity = (int)$request->post('quantity');
        $user = $request->user();
        if($user){
            $cartItem = CartItem::where(['user_id'=>$user->id, 'product_id'=>$product->id])->update(['quantity'=>$quantity]);

            return response(['count'=>Cart::getCartItemsCount()]);
        }else{
            $cartItems = Cart::getCookieCartItems();
            foreach($cartItems as &$cartItem){
                if($cartItem['product_id'] == $product->id){
                    $cartItem['quantity'] = $quantity;
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);

            return response(['count'=>Cart::getCountFromItems($cartItems)]);
        }
    }
}
