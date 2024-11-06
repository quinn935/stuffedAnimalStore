
     <x-app-layout>
        {{-- hero img --}}
            <div
                class="h-screen min-h-[400px]">
                <div style="background-image:  url(/img/banner-desktop.jpg)"
                 class="bg-cover bg-center w-full h-full"></div>
            </div>
            <div
            class="h-screen min-h-[400px]">
            <div style="background-image: url(./img/banner-desktop2.jpg)"
            class="bg-cover bg-center bg-fixed w-full h-full"></div>
            </div>

            <section class="bg-rose-500 py-20 px-10">
                <h1 class="font-semibold text-center tracking-widest text-rose-50 text-2xl uppercase">
                    Find your best friend
                </h1>
                <div class="flex flex-col lg:flex-row justify-center items-center py-20 px-4 gap-20 lg:gap-6">
                        <div class="flex flex-col lg:flex-row w-[32rem] lg:w-[48rem] h-96 lg:h-[32rem]">
                            <img src="./img/card-img-2.jpg" alt="" class="w-full lg:w-2/3 h-full lg:rounded-l-3xl">
                            <div class="w-full lg:w-1/3 bg-blue-400 lg:rounded-r-3xl flex items-center justify-center">
                                <div class="text-2xl uppercase tracking-wide text-center">Explore our classic collections</div>
                            </div>
                        </div>
                        <div class="w-[32rem] h-96 lg:h-[32rem] relative">
                            <img src="./img/card-image-1.jpg" alt="" class="w-full h-full shadow-xl rounded-3xl">
                            <div class="absolute bottom-0 bg-blue-400 w-full py-2 lg:py-6 lg:rounded-b-3xl text-center text-xl tracking-wide uppercase">Meet your new friends</div>
                        </div>
                </div>
            </section>

            <section class="py-10 xl:px-10 xl:py-16 bg-white">
                <h1 class="uppercase tracking-widest ml-10 text-3xl">Popular Stars</h1>
                         <!-- Product List -->
          {{-- <div
          class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:gap-4 lg:grid-cols-3 xl:grid-cols-4 p-5 px-10 py-20"
        > --}}

          <!-- Product Item -->
        <div x-data="swiper" class="swiper swiper-container x-full h-full xl:mt-6" x-ref="swiperContainer">
              <!-- Wrapper for slides -->
            <div class="swiper-wrapper pb-10 xl:pb-14">
                @foreach($products as $product)
                <div class="swiper-slide flex items-center justify-center">
                    <div
                        x-data="productItem({{ json_encode([
                        'addToCartUrl' => route('cart.add', $product)//fetch(url)
                        ])}})"
                        class="w-56 h-76 md:w-64 md:h-84 xl:w-80 xl:h-96 group rounded-md bg-white cursor-pointer"
                    >
                        {{-- <a href="{{ route('product.view', $product->slug ) }}" class="block overflow-hidden aspect-w-3 aspect-h-2"> --}}
                        <img
                            src="{{ $product->getMainImageAttribute() }}"
                            alt=""
                            class="block rounded-lg transition object-cover group-hover:hidden"
                        />
                        <img
                        src="{{ $product->getSecondImageAttribute() }}"
                        alt=""
                        class="hidden group-hover:block rounded-lg transition object-cover"
                        />
                        </a>
                        <div class="text-center group-hover:hidden">
                        <h3 class="text-lg lg:text-xl tracking-wider mb-1">
                            {{-- <a href="{{ route('product.view', $product->slug) }}"> --}}
                            {{ $product->title }}
                            {{-- </a> --}}
                        </h3>
                        <h5 class="font-bold text-center text-md">${{ $product->price }}</h5>
                        </div>
                        <div class="hidden transition group-hover:flex group-hover:items-center group-hover:justify-center mt-1">
                            <button @click="addToCart()" class="cursor-pointer py-1 px-2 lg:py-2 lg:px-4 bg-rose-400 border-black border-2 tracking-wide text-md lg:text-xl text-white rounded shadow">Add to Cart</Button>
                        </div>
                    </div>
                </div>
             @endforeach
        {{-- end of product item --}}
        </div>
          <!-- Swiper Pagination  -->
          <div class="swiper-pagination bottom-10" x-ref="pagination"></div>

          <!-- Swiper Navigation buttons  -->
          <div class="swiper-button-prev !text-gray-500" x-ref="prevButton"></div>
          <div class="swiper-button-next !text-gray-500" x-ref="nextButton"></div>
     </div>
     </section>

     </x-app-layout>

