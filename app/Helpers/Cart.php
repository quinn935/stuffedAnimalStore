<?php

namespace App\Helpers;

use App\Models\CartItem;

class Cart{
    public static function getCartItemsCount(): int
    {
        $request = \request();
        $user = $request->user();
        if($user){
            return CartItem::where('user_id', $user->id)->sum('quantity');
        }else{
            $cartItem = self::getCookieCartItems();
            return array_reduce(
                $cartItem,
                fn($carry, $item)=>$carry+$item['quantity'],
                0
            );
        }
    }


    public static function getCartItems()
    {
        $request = \request();
        $user = $request->user();
        if($user){
            return CartItem::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_id'=>$item->product_id, 'quantity'=>$item->quantity, 'price'=>$item->product->price, 'product_title'=>$item->product->title, 'product_slug'=>$item->product->slug, 'product_image'=>$item->product->getMainImageAttribute()]
            );
        }else{
            return self::getCookieCartItems();
        }
    }

    public static function getCookieCartItems()
    {
        $request = \request();
        return json_decode($request->cookie('cart_items', '[]'), true);
    }


    public static function getCountFromItems($cartItems){
        return array_reduce($cartItems,
                            fn($carry, $item)=>$carry + $item['quantity'],
                            0);
    }

    public static function moveCookieCartItemsToDB()
    {
        $request = \request();
        $user = $request->user();
        $cartItems = self::getCookieCartItems();
        $oldCartItemsInDB = CartItem::where('user_id', $user->id)->get()->keyBy('product_id');
        $newCartItems = [];
        foreach($cartItems as $cartItem){
            if(isset($oldCartItemsInDB[$cartItem['product_id']])){
                continue;
            }
            $newCartItems[] = [
                'user_id' => $user->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity']
            ];

        }
        if(!empty($newCartItems)){
            CartItem::insert($newCartItems);
        }
    }
}

?>
