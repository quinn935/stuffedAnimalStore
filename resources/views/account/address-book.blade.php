<x-app-layout>
    <div class="min-h-screen bg-white">
        @include('account.header')

        <div class="container mx-auto">
            <div class="grid grid-cols-1 gap-8 py-8 md:grid-cols-2 xl:grid-cols-3 mx-12 md:mx-8 lg:gap-12 default-text-color">
                {{-- loop customer addresses --}}
                @if($customer_addresses)
                    @foreach($customer_addresses as $address)
                        <div class="bg-gray-50 w-full h-56 border flex flex-col items-start justify-start gap-2 cursor-pointer  p-8">
                            <h1 class="font-semibold text-gray-700 text-2xl capitalize">
                                {{ $address->first_name }}&nbsp;{{ $address->last_name }}
                            </h1>
                            <p class="capitalize">{{ $address->address1 }}&nbsp;{{ $address->address2 }}</p>
                            <p class="capitalize">{{ $address->city }}, {{ $address->state }}&nbsp; {{ $address->zipcode }}</p>
                            <p class="capitalize">United States</p>
                            <p class="capitalize">Phone:&nbsp; {{ $address->phone }}</p>
                        </div>
                    @endforeach
                @endif
                {{-- end of loop customer addresses --}}
                {{-- add address box --}}
                <a href="{{ route('account.show', ['type'=> 'address']) }}">
                    <div class="bg-white w-full h-56 border flex flex-col items-center justify-center text-xl gap-2 cursor-pointer hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <p class="capitalize">new address</p>
                    </div>
                </a>
                {{-- end of add address box --}}
            </div>
        </div>
    </div>
</x-app-layout>
