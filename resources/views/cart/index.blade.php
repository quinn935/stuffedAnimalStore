<x-app-layout>
    <div x-data="{
         cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
         cartItems: {{
                json_encode($products->map(fn($product) => [
                'id' => $product->id,
                'slug' => $product->slug,
                'image' => $product->getMainImageAttribute(),
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $cartItems[$product->id]['quantity'],
                'removeUrl' => route('cart.remove', $product),
                'updateQuantityUrl' => route('cart.update-quantity', $product)
            ]))
            }},
             getCartTotal(){
                return this.cartItems.reduce((acc, item)=> acc + item.price * item.quantity, 0).toFixed(2)
             },
             getProductTotal(item){
                return (item.price * item.quantity).toFixed(2)
             }
    }"
        @cart-change.window = "cartItemsCount = $event.detail.count"
        class="container py-28 mx-auto text-gray-600 text-lg tracking-wide lg:text-xl">
        <template x-if="cartItemsCount>0">
            <div class="">
                <h1 class="text-center text-2xl md:text-3xl mb-4 md:mb-10 mt-2 md:mt-6">
                    Your Cart (<span x-text="cartItemsCount"></span> Items)
                </h1>
                <div class="px-4 md:px-6 xl:px-10 xxl:px-20">
                    {{-- mobile --}}
                        <table class="md:hidden table-auto w-full">
                            <tbody class="border-y">
                                <template x-for="cartItem of cartItems">
                                    <tr x-data="productItem(cartItem)">
                                        <td class="border-b px-2 py-4">
                                            <img :src="cartItem.image" alt="" class="w-20 h-20">
                                        </td>
                                        <td class="flex flex-col items-start justify-center px-2 py-4">
                                            {{-- item title --}}
                                            <h1 class="tracking-wider mb-4 text-xl" x-text="cartItem.slug"></h1>
                                            {{-- end of item title --}}
                                            {{-- item price --}}
                                            <div class="flex justify-center items-around text-md mb-1">
                                                <div class="">Price:</div>
                                                &nbsp; &nbsp; &nbsp;
                                                <div>$<span x-text="cartItem.price"></span></div>
                                            </div>
                                            {{-- end of item price --}}
                                            {{-- item quantity --}}
                                            <div class="flex justify-center items-around text-md mb-1">
                                                <div>Quantity:</div>
                                                &nbsp; &nbsp; &nbsp;
                                                <input type="number" x-model="cartItem.quantity"
                                                @change="changeQuantity()" class="py-1 border-gray-200 focus:border-cyan-600 focus:ring-cyan-600 w-16 text-sm">
                                            </div>
                                            {{-- end of item quantity --}}
                                            {{-- item subtotal --}}
                                            <div class="flex justify-center items-around text-md mb-1">
                                                <div>Total:</div>
                                                &nbsp; &nbsp; &nbsp;
                                                <div>$<span x-text="getProductTotal(cartItem)"></span></div>
                                            </div>
                                            {{-- end of item subtotal --}}
                                        </td>
                                        <td>
                                            {{-- remove the item from cart --}}
                                            <div @click="removeItemFromCart()" class="hover:scale-110 cursor-pointer mr-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                            </div>
                                            {{-- end of remove item --}}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                          </table>
                    {{-- end of mobile --}}


                    {{-- desktop --}}
                    <table class="hidden md:table table-auto w-full">
                        <thead>
                            <tr class="text-left">
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="border-y">
                            <template x-for="cartItem of cartItems">
                                <tr x-data="productItem(cartItem)">
                                    <td class="p-2 border-b flex items-center gap-4 lg:gap-10">
                                        <img :src="cartItem.image" alt="" class="w-20 h-20">
                                        <h1 x-text="cartItem.slug"></h1>
                                    </td>
                                    <td class="border-b p-2">
                                        $<span x-text="cartItem.price"></span>
                                    </td>
                                    <td class="border-b p-2">
                                        <input type="number" x-model="cartItem.quantity"
                                            @change="changeQuantity()" class="py-1 border-gray-200 focus:border-cyan-600 focus:ring-cyan-600 w-16">
                                    </td>
                                    <td class="border-b p-2">
                                        <div class="flex items-center">
                                            <div class="flex items-center gap-2 lg:gap-4">
                                                <h1>$ <span x-text="getProductTotal(cartItem)"></span></h1>
                                                <div></div>
                                            </div>
                                            <div @click="removeItemFromCart()" class="hover:scale-110 cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                  </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div class="ml-auto w-1/2 px-4 md:px-10 xl:px-20 mt-12">
                        <div class="flex justify-between items-center border-b p-2 md:p-4">
                            <div class="font-semibold  text-gray-700">Subtotal: </div>
                            <h1>$ <span x-text="getCartTotal()"></span></h1>
                        </div>
                        <div class="flex justify-between items-center border-b p-2 md:p-4">
                            <div class="font-semibold  text-gray-700">Estimated Shipping: </div>
                            <h1>Free</h1>
                        </div>
                        <div class="flex justify-between items-center border-b p-2 md:p-4">
                            <div class="font-semibold text-gray-700">Grand Total: </div>
                            <h1>$ <span x-text="getCartTotal()"></span></h1>
                        </div>
                    </div>
                    {{-- end of desktop --}}
                </div>
            </div>

        </template>

        {{-- no items in the cart --}}
        <template x-if="cartItemsCount === 0">
            <div class="text-center py-8 text-gray-500">
                Your Cart is empty.
            </div>
        </template>

    </div>
</x-app-layout>
