<x-app-layout>
        {{-- item pic and info --}}
        <div class="py-20 mb-20 px-4">
            <div x-data="productItem({{ json_encode([
                'id' => $product->id,
                'images' => $product->images,
                'title' => $product->title,
                'description' => $product->description,
                'price' => $product->price,
                'addToCartUrl' => route('cart.add', $product),
            ]) }})" class="mx-auto py-20 2xl:py-24">

                <div class="grid gap-2 grid-cols-1 md:grid-cols-10 h-96" x-data="{
                    images: {{ json_encode($product->images) }},
                    activeImage: null,
                    prev() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === 0) {
                            index = this.images.length;
                        }
                        this.activeImage = this.images[index - 1];
                    },
                    next() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === this.images.length - 1) {
                            index = -1;
                        }
                        this.activeImage = this.images[index + 1];
                    },
                    init() {
                        this.activeImage = this.images.length > 0 ? this.images[0] : null;
                    }
                }">
                    <div class="md:col-span-2 flex md:flex-col items-end justify-start">
                        <template x-for="image of images">
                            <a @click.prevent="activeImage = image"
                                class="cursor-pointer border border-gray-300 hover:border-cyan-500"
                                :class="{ 'border-cyan-600': activeImage === image }">
                                <img :src="image.url" alt="" class="object-fit h-40 w-40">
                            </a>
                        </template>
                    </div>
                    <div class="md:col-span-5 lg:col-span-4">
                        <div class="relative">
                            <div x-show="activeImage" class="">
                                <img :src="activeImage.url" class="max-h-[450px] md:max-h-[650px]">
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 pb-10 md:pt-0 md:pb-0 md:col-span-3 lg:col-span-4 text-gray-500 md:ml-4 lg:ml-10">
                        <h1 class="text-2xl lg:text-3xl font-semibold mb-6">
                            {{ $product->title }}
                        </h1>
                        <div class="flex font-bold text-lg mb-6">${{ $product->price }}</div>
                        <div class="xl:mr-10">{{ $product->description }}</div>
                        <button @click="addToCart()"
                            class="mt-4 bg-cyan-500 px-6 py-2 capitalize text-lg text-black hover:bg-cyan-400 hover:border border-black shadow">
                            add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end of item pic and info --}}

    {{-- item details dropdown --}}
    <div class="pt-64 pb-20 mt-8 md:pt-20 md:mt-0 xl:pt-16 4xl:mt-12 6xl:mt-20">
        <div class="container mx-auto px-6 pb-32">
            <div class="max-w-4xl xl:max-w-6xl my-8 mx-auto overflow-hidden text-gray-500 text-lg md:text-xl">
                {{-- tab 1 --}}
                <div class="py-1 border-b border-gray-300 outline-none group" tabindex="1">
                    {{-- tab flex container --}}
                    <div
                        class="flex items-center justify-between py-3  transition duration-500 cursor-pointer group ease">
                        <div
                            class="transition duration-500 group-hover:text-gray-600 0 uppercase">
                            product details
                        </div>
                        <div class="transition duration-500 ease group-focus:-rotate-180 group-focus:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    {{-- end of tab flex container --}}
                    {{-- tab inner content --}}
                    <div class="overflow-hidden transition duration-500 group-focus:max-h-screen max-h-0 ease md:text-lg">
                        <ul class="py-2 capitalize">
                            @if ($product->length )
                                 <li>Dimensions: {{ $product->length }}in * {{ $product->width }}in * {{ $product->depth }}in</li>
                            @endif
                            @if ($product->sitting_height)
                                <li>Sitting Height: {{ $product->sitting_height }}in</li>
                            @endif
                            @if ($product->main_material)
                                <li>Main Material: {{ $product->main_material }}</li>
                            @endif
                            @if ($product->inner_filling_material)
                                <li>Inner Filling: {{ $product->inner_filling_material }}</li>
                            @endif
                            @if ($product->hard_eyes)
                                <li>Hard Eyes</li>
                            @endif
                            @if ($product->inner_filling_material)
                                <li>Inner filling material: {{ $product->inner_filling_material }}</li>
                            @endif
                        </ul>
                    </div>
                    {{-- end of tab inner content --}}
                </div>
                {{-- end of tab 1 --}}
                      {{-- tab 2 --}}
                      <div class="py-1 border-b border-gray-300 outline-none group" tabindex="1">
                        {{-- tab flex container --}}
                        <div
                            class="flex items-center justify-between py-3  transition duration-500 cursor-pointer group ease">
                            <div
                                class="transition duration-500  group-hover:text-gray-600 0 uppercase">
                                safety & care
                            </div>
                            <div class="transition duration-500 ease group-focus:-rotate-180 group-focus:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        {{-- end of tab flex container --}}
                        {{-- tab inner content --}}
                        <div class="overflow-hidden transition duration-500 group-focus:max-h-screen max-h-0 ease md:text-lg">
                            <ul class="py-2">
                                <li>
                                    Care Instructions: 86 degree Fahrenheit wash only. Do not tumble dry, dry clean, or iron. Check all labels upon arrival of purchase
                                </li>
                                <li>
                                    Safety Recommendations: suitable from birth
                                </li>
                            </ul>
                        </div>
                        {{-- end of tab inner content --}}
                    </div>
                    {{-- end of tab 2 --}}
                              {{-- tab 3 --}}
                              <div class="py-1 border-b border-gray-300 outline-none group" tabindex="1">
                                {{-- tab flex container --}}
                                <div
                                    class="flex items-center justify-between py-3  transition duration-500 cursor-pointer group ease">
                                    <div
                                        class="transition duration-500  group-hover:text-gray-600 0 uppercase">
                                        shipping & returns
                                    </div>
                                    <div class="transition duration-500 ease group-focus:-rotate-180 group-focus:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </div>
                                </div>
                                {{-- end of tab flex container --}}
                                {{-- tab inner content --}}
                                <div class="overflow-hidden transition duration-500 group-focus:max-h-screen max-h-0 ease md:text-lg">
                                    <p class="py-2">We offer free shipping and returns for orders in the United States. </p>
                                </div>
                                {{-- end of tab inner content --}}
                            </div>
                            {{-- end of tab 3 --}}
            </div>
        </div>
        {{-- end of item dropdown --}}
    </div>



</x-app-layout>
