<x-app-layout>
    <div class="py-20 px-4">
        <div x-data="productItem({{ json_encode([
            'id' => $product->id,
            'images' => $product->images,
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'addToCartUrl' => route('cart.add', $product),
        ]) }})" class="mx-auto py-20 2xl:py-24">

            <div class="grid gap-2 grid-cols-1 md:grid-cols-10 h-96"
                 x-data="{
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
                            :class="{'border-cyan-600': activeImage === image}"
                        >
                            <img :src="image.url" alt="" class="object-fit h-40 w-40">
                        </a>
                    </template>
                </div>
                <div class="md:col-span-5 lg:col-span-4">
                        <div class="relative">
                            <div x-show="activeImage" class="">
                                <img :src="activeImage.url" class="">
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

        </div>
    </div>
</x-app-layout>
