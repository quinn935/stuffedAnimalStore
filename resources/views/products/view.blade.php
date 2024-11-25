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
            'productAverageRating' => $product->getProductAverageReviewAttribute(),
            'reviewsCount' => $product->reviews->count(),
        ]) }})"
            @update-product-average-rating.window = "product.productAverageRating = $event.detail.rating"
            @update-product-review-count.window="product.reviewsCount = $event.detail.count"
             class="mx-auto py-20 2xl:py-24">

            <div class="grid gap-2 grid-cols-1 md:grid-cols-10 h-96" x-data="{
                images: {{ json_encode($product->images) }},
                activeImage: null,
                init() {
                    this.activeImage = this.images.length > 0 ? this.images[0] : null;
                }
            }">
                <div class="md:col-span-2 flex md:flex-col items-end justify-start">
                    <template x-for="image of images" :key="image.url">
                        <div @click="activeImage = image;"
                            class="cursor-pointer border hover:border-gray-400"
                            :class="{ 'border-cyan-500': activeImage && activeImage.url === image.url }">
                            <img :src="image.url" alt="" class="object-fit h-40 w-40">
                         </div>
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
                    <div class="font-bold text-lg mb-4">${{ $product->price }}</div>
                    <div class="flex items-center gap-6 md:flex-col md:items-start mb-6 md:gap-2 lg:flex-row lg:items-center lg:gap-6">

                        <div x-show="product.reviewsCount>0" class="flex items-center">
                            <div x-text="product.productAverageRating"></div>
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 inline"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.157c.969 0 1.372 1.24.588 1.81l-3.366 2.448a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.366-2.448a1 1 0 00-1.176 0l-3.366 2.448c-.784.57-1.839-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.98 9.394c-.784-.57-.381-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.967z" />
                                </svg>
                                Rating
                            </div>
                        </div>
                        <div>
                            <template x-if="product.reviewsCount>0">
                                (<div><span  x-text="product.reviewsCount"></span> Reviews</div>)
                            </template>
                            <template x-if="product.reviewsCount===0">
                               (<span>No reviews yet.</span>)
                             </template>
                        </div>
                            <div @click="$dispatch('open-product-review-form');" class="hover:text-gray-700 underline cursor-pointer">
                                Write a review
                            </div>

                    </div>
                    <div class="xl:mr-10">{{ $product->description }}</div>
                    <button @click="addToCart()" class="mt-4 primary-btn">
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
                        <div class="transition duration-500 group-hover:text-gray-600 0 uppercase">
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
                    <div
                        class="overflow-hidden transition duration-500 group-focus:max-h-screen max-h-0 ease md:text-lg">
                        <ul class="py-2 capitalize">
                            @if ($product->length)
                                <li>Dimensions: {{ $product->length }}in * {{ $product->width }}in *
                                    {{ $product->depth }}in</li>
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
                        <div class="transition duration-500  group-hover:text-gray-600 0 uppercase">
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
                    <div
                        class="overflow-hidden transition duration-500 group-focus:max-h-screen max-h-0 ease md:text-lg">
                        <ul class="py-2">
                            <li>
                                Care Instructions: 86 degree Fahrenheit wash only. Do not tumble dry, dry clean, or
                                iron. Check all labels upon arrival of purchase
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
                        <div class="transition duration-500  group-hover:text-gray-600 0 uppercase">
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
                    <div
                        class="overflow-hidden transition duration-500 group-focus:max-h-screen max-h-0 ease md:text-lg">
                        <p class="py-2">We offer free shipping and returns for orders in the United States. </p>
                    </div>
                    {{-- end of tab inner content --}}
                </div>
                {{-- end of tab 3 --}}

                {{-- tab 4 --}}
                <div x-data @click="$dispatch('toggle-review-content')" class="py-1 border-b border-gray-300 outline-none"
                    tabindex="1">
                    {{-- tab flex container --}}
                    <div class="flex items-center justify-between py-3  transition duration-500 cursor-pointer  ease">
                        <div class="transition duration-500 hover:text-gray-600 0 uppercase">
                            product reviews
                        </div>
                        <div x-data="{
                                    count: {{ $product->reviews->count() }},
                                    rating: {{ $product-> getProductAverageReviewAttribute() }} }"
                                     @update-product-review-count.window="count = $event.detail.count"
                                     @update-product-average-rating.window="rating = $event.detail.rating"
                            class="flex gap-2">
                            <div class="flex items-center">
                                <div x-text="rating"></div>
                                <di class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-500 inline"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.157c.969 0 1.372 1.24.588 1.81l-3.366 2.448a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.366-2.448a1 1 0 00-1.176 0l-3.366 2.448c-.784.57-1.839-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.98 9.394c-.784-.57-.381-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.967z" />
                                    </svg>
                            </div>

                            <div x-text="count"></div>
                            <div @click="$dispatch('open-product-review-form');" class="hover:text-gray-700 underline">
                                Write a review
                            </div>

                            <div class="transition duration-500 ease group-focus:-rotate-180 group-focus:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d=" m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- review tab inner content --}}
                <div x-data="{ visible: true,
                            reviews: {{ json_encode($product->reviews->map(fn($review)=>[
                                'id' => $review->id,
                                'subject' => $review->review_subject,
                                'comment' => $review->review_comment,
                                'author' => $review->user->name,
                                'rating' => $review->rating,
                                'updated_at' => $review->updated_at
                            ])) }}, }"
                     @toggle-review-content.window="visible=!visible" x-show="visible"
                     @open-review-content-after-post-new-review.window="visible=true"
                     @update-product-reviews.window="reviews = $event.detail.reviews"
                    @click.outside="visible=false;" transition class="overflow-hidden transition duration-500  ease md:text-lg">
                    <div class="w-full py-4 text-gray-600 overflow-y-auto h-80">
                        <template x-for="review in reviews" :key="review.id">
                                <div class="mb-4 pb-4 border-b">
                                    <div class="font-semibold tracking-wide">
                                        "<span x-text="review.subject"></span>"
                                    </div>
                                    <div class="w-full md:w-2/3 flex flex-col md:flex-row md:gap-20">
                                        <div>
                                            <template x-for="i in review.rating" :key="i">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-yellow-500 inline" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.157c.969 0 1.372 1.24.588 1.81l-3.366 2.448a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.366-2.448a1 1 0 00-1.176 0l-3.366 2.448c-.784.57-1.839-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.98 9.394c-.784-.57-.381-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.967z" />
                                                </svg>
                                            </template>
                                            <template x-for="i in (5 - review.rating)" :key="`empty-${i}`">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-300 inline" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.157c.969 0 1.372 1.24.588 1.81l-3.366 2.448a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.366-2.448a1 1 0 00-1.176 0l-3.366 2.448c-.784.57-1.839-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.98 9.394c-.784-.57-.381-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.967z" />
                                                </svg>
                                            </template>
                                        </div>
                                        <div x-data="dateFormatter(review.updated_at)" class="text-sm">
                                            By <span x-text="review.author"></span>,&nbsp;&nbsp;&nbsp;
                                            <span x-text="formattedDate()"></span>
                                        </div>
                                    </div>
                                    <div class="w-full px-2 py-1">
                                        <p x-text="review.comment"></p>
                                    </div>
                                </div>
                        </template>
                    </div>
                </div>
            </div>
            {{-- end of tab  --}}
        </div>
    </div>
    {{-- end of item dropdown --}}
    </div>


    {{-- product review form modal --}}
    <div x-data="reviewFormHandler({
        product_id: {{ $product->id }},
        created_by: {{ auth()->user()->id }},
        updated_by: {{ auth()->user()->id }},
        postReviewUrl: '{{ route('product-review.store', $product) }}'
    })" x-show="visible" @open-product-review-form.window="visible=true" x-cloak
        @click.outside="visible=false; $dispatch('remove-overlay');"
        class="bg-white pt-2  pb-10 z-50 fixed top-1/2 left-1/2 shadow w-4/5 xl:w-2/3 3xl:w-1/2  -translate-x-1/2 -translate-y-1/2 text-gray-600 max-h-[90vh] overflow-y-auto"
        style="display: none">
        <div class="flex items-center justify-between pl-4 pr-2 py-4 border-b border-b-gray-200  ">
            <h1 class="text-2xl">Write a Review</h1>
            <button class="w-[30px] h-[30px]" @click="visible=false; $dispatch('remove-overlay');">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="py-6 px-2 flex flex-col md:flex-row items-center justify-center md:gap-4">
            <div class="md:basis-1/2">
                <img src="{{ $product->getMainImageAttribute() }}" class="w-full max-h-96 md:max-h-fit">
                <h1 class="capitalize text-center text-2xl mb-6">{{ $product->slug }}</h1>
            </div>
            <div class="w-4/5 md:basis-1/2 md:self-start text-lg text-gray-600">
                {{-- product review form --}}
                <form @submit.prevent="submitReviewForm">
                    @csrf

                    <input type="hidden" name="product_id" x-model="formData.product_id">
                    <input type="hidden" name="created_by" x-model="formData.created_by">
                    <input type="hidden" name="updated_by" x-model="formData.updated_by">


                    <div class="mb-6">
                        <label for="rating" class="block mb-1">Rating</label>
                        <select name="rating" id="rating" class="product-review-input"
                            x-model="formData.rating">
                            <option value="" selected>Select Rating</option>
                            <option value="1">1 star(worst) </option>
                            <option value="2">2 stars</option>
                            <option value="3">3 stars</option>
                            <option value="4">4 stars</option>
                            <option value="5">5 stars(best)</option>
                        </select>
                        <p class="text-red-500 text-sm" x-text="errors.rating"></p>
                    </div>

                    <div class="mb-6">
                        <label for="review_subject" class="block mb-1">Review Subject</label>
                        <input type="text" name="review_subject" x-model="formData.review_subject"
                            class="product-review-input">
                         <p class="text-red-500 text-sm" x-text="errors.review_subject"></p>
                    </div>

                    <div class="mb-6">
                        <label for="review_comment" class="block mb-1">Comments</label>
                        <textarea rows="5" name="review_comment" x-model="formData.review_comment" class="product-review-input"></textarea>
                        <p class="text-red-500 text-sm" x-text="errors.review_comment"></p>
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="primary-btn">Submit Review</button>
                    </div>
                </form>
                {{-- end of product review form --}}
            </div>

        </div>

    </div>
    {{-- end of product review form modal --}}

</x-app-layout>
