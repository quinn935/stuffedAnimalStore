@php
    use App\Models\Category;
@endphp

{{-- <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav> --}}

<nav x-data="{
    cartItemsCount: {{ json_encode(\App\Helpers\Cart::getCartItemsCount()) }},
    cartItems: {{ json_encode(\App\Helpers\Cart::getCartItems()) }},
    get cartItemsTotalPrice() {
        return this.cartItems.reduce((acc, item) => (acc + item.quantity * item.price), 0).toFixed(2)
    }
}" @cart-change.window = "cartItemsCount = $event.detail.count"
    @cart-items-change.window = "cartItems = $event.detail.cart_items"
    class="fixed text-zinc-600 flex top-0 bg-cyan-500 w-full h-20 justify-between  shadow-lg rounded-b-lg z-10">
    <div class="flex items-center p-2 gap-2">
        <img src="/img/logo.png" alt="logo" width="80">
        <div class="text-2xl">BEAR</div>
    </div>

    {{--  mobile right hand side navigation for burger icon --}}
    <div class="block md:hidden ml-auto pr-4 my-auto cursor-pointer">
        <button id="menu-btn" type="button" class="z-40 block focus:outline-none">
            <span class="hamburger-top"></span>
            <span class="hamburger-middle"></span>
            <span class="hamburger-bottom"></span>
        </button>
    </div>
    {{-- end of burger icon --}}

    {{-- nav items --}}
    <div class="md:flex hidden items-end justify-center uppercase text-zinc-700

    ">
        {{-- new in --}}
        <div class="menu-item hover:border-b border-cyan-700">
            <span>New In</span>
        </div>
        {{-- end of new in --}}
        {{-- explore all --}}
        <div class="menu-item hover:border-b border-cyan-700 ">
            <span>Explore All</span>
        </div>
        {{-- end of explore all --}}
        {{-- animals --}}
        @foreach ($categories as $category)
            <div class="menu-item group">
                <span class="hover:border-b hover:border-cyan-700">{{ $category->name }}</span>
                <div
                    class="hidden group-hover:block absolute top-full right-0 whitespace-nowrap rounded-b-md text-right bg-cyan-500 py-4">
                    @php
                        $childCategories = Category::where(['active' => 1, 'parent_id' => $category->id])->get();
                    @endphp
                    @foreach ($childCategories as $childCategory)
                        <div class="mx-8 mt-2 mb-2 cursor-pointer capitalize tracking-wider">
                            <a href="{{ route('categories.view-products-by-category', $childCategory->slug) }}"
                                class="hover:border-b hover:border-cyan-700 px-2 text-lg">{{ $childCategory->name }}</a>
                        </div>
                    @endforeach
                    <div class="mx-8 mt-2 mb-2 cursor-pointer capitalize">
                        <span
                            class="text-sm font-semibold uppercase hover:border-b hover:border-cyan-700 px-2 tracking-tight">view
                            all</span>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    {{-- end of nav items --}}

    {{-- nav user & cart icon --}}
    <div class="flex justify-end items-end text-white-500 gap-4 text-lg">
        <div class="relative group cursor-pointer">
            <div class="inline-flex items-center h-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <div class="relative">
                    <span>Cart</span>
                    <small x-transition x-cloak x-text="cartItemsCount"
                        class="absolute z-[100] -top-2 -right-4 py-[1px] px-[7px] rounded-full bg-yellow-500 text-sm">
                    </small>
                </div>
            </div>
            {{-- hover cart items --}}
            <div
                class="hidden group-hover:block absolute top-full -translate-x-1/2 left-1/2 max-w-80 min-w-72 bg-white shadow rounded-b cursor-auto">
                <div x-show="cartItemsCount===0">
                    <div class="py-8 text-center border-b">Your Cart is empty.</div>
                </div>
                    <div x-show="cartItemsCount>0" class="max-h-64 overflow-y-auto">
                        <template x-for="cartItem in cartItems">
                            <div class="flex py-2 gap-4 border-b">
                                <div class="w-20 h-20 pl-4">
                                    <img :src="cartItem.product_image" :alt="cartItem.product_title"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="pr-4 my-2">
                                    <a :href="'{{ route('products.view', '') }}/' + cartItem.product_slug" class="text-sm mb-2 hover:text-gray-400" x-text="cartItem.product_title"></a>
                                    <div class="text-sm flex items-center">
                                        <div x-show="cartItem.quantity>1">
                                            <span x-text="cartItem.quantity"></span> *
                                        </div>
                                        $<span x-text="cartItem.price"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="cartItemsCount>0" class="p-2 border">
                        <div class="flex items-center justify-around my-2">
                            <div>Cart Total:</div>
                            <div>$<span x-text="cartItemsTotalPrice"></span></div>
                        </div>
                        <div class="p-2 text-center mb-2">
                            <a href="{{ route('cart.index') }}" class="white-btn">View Bag & Check out</a>
                        </div>
                    </div>
                </template>
            </div>
            {{-- end of hover cart items --}}
        </div>
        @if (!Auth::guest())
            <li x-data="{ open: false }" class="relative list-none">
                <a @click="open = !open"
                    class="p-3 pb-1 flex items-center justify-center md:text-lg cursor-pointer hover:bg-rose-600">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        My Account
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                {{-- my account drop down --}}
                <ul @click.outside="open = false" x-show = "open" x-transition x-cloak
                    class="absolute z-10 top-full right-0 whitespace-nowrap rounded-b-md text-right bg-rose-500">
                    <li>
                        <a href="#" class="flex px-4 py-2 hover:bg-rose-400 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            My Profile
                        </a>
                    <li>
                        <a href="#" class="flex px-3 py-2 hover:bg-rose-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            My Orders
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="flex w-full px-3 py-2 hover:bg-rose-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
            </li>
            {{-- end of my account drop down --}}
            </li>
        @else
            <a href="{{ route('login') }}" class="flex items-center p-3 pb-1 text-lg hover:bg-rose-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Login
            </a>
        @endif
        {{-- <div class="flex items-center p-3 pb-1 text-lg md:text-2xl">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-7 w-7 mr-2"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
            />
          </svg>
        </div> --}}
    </div>
    </ul>

    {{--  end of nav user & cart icon   --}}
</nav>
