<x-app-layout>

<div class="w-full h-full bg-white">
    <!-- {{-- banner image --}} -->
    <div class="h-60 xl:h-72 w-full relative text-white">
        <div class="h-full w-full">
            <div style="background-image:  url(/img/categories/category-banner-1.jpg)"
            class="bg-cover bg-center w-full h-full"></div>
        </div>
        <div class="absolute bottom-0 left-0 px-6 py-4 xl:py-6 xl:px-10 2xl:px-16 2xl:py-8 w-1/2">
            <p class="text-xl tracking-wider w-full md:text-2xl mb-2">Home /{{ $parentCategory->name }} / {{ $category->name }}</p>
            <p class="text-2xl lg:text-3xl uppercase font-semibold">{{ $category->name }}</p>
        </div>
    </div>
    <!-- {{-- end of banner image --}}

    {{-- products section --}} -->
    <section class="flex items-center justify-center">
    <div
    class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:gap-6 2xl:gap-16 lg:grid-cols-3 xl:grid-cols-4 p-5 px-10 py-20">
        @foreach($products as $product)
    <!-- Product Item -->
    <div
      x-data="productItem({{ json_encode([
        'addToCartUrl' => route('cart.add', $product)
      ])}})"
      class="w-72 h-88 2xl:w-80 2xl:h-92 group rounded-md bg-white cursor-pointer mb-6 mx-4"
    >
      <a href="{{ route('products.view', $product) }}" class="block overflow-hidden aspect-w-3 aspect-h-2">
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
      <div class="text-center">
        <h3 class="text-lg tracking-wider mb-1 hover:text-gray-500 transition duration-200">
           <a href="{{ route('products.view', $product) }}">
                {{ $product->title }}
           </a>
        </h3>
      </div>
      <div class="w-full h-10">
        <h3 class="block group-hover:hidden text-lg text-center mt-1">$ {{ $product->price }}</h3>
        <div class="hidden group-hover:flex group-hover:items-center group-hover:justify-center mt-1 transition">
            <button @click="addToCart()" class="text-lg cursor-pointer py-1 px-2  bg-cyan-500 border-black border-2 tracking-wide  text-white rounded shadow mt-1">Add to Cart</Button>
        </div>
      </div>
    </div>
<!--
  {{-- end of product item --}} -->
  @endforeach
</div>
    </section>

    <!-- {{-- end of products section --}} -->
    </div>
</x-app-layout>
