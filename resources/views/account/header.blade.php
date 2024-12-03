
    <div class="py-10 bg-white">
        <h1 class="text-3xl md:text-4xl capitalize text-center default-text-color font-semibold">{{ $page_title }}</h1>
        {{-- account page links --}}
        <div class="pt-6 pb-4 md:pb-8 lg:mb-4 md:text-xl flex gap-8 items-center justify-center text-gray-500 border-b max-w-6xl mx-auto">
            <div class="hover:text-gray-700">
                <a href="{{ route('account.show', ['type' => 'orders']) }}">Orders</a>
            </div>
            <div class=" hover:text-gray-700 ">
                <a href="{{ route('account.show', ['type' => 'address_book']) }}">Addresses</a>
            </div>
            <div class=" hover:text-gray-700 ">
                <a href="{{ route('account.show', ['type' => 'account_details']) }}">Account Details</a>
            </div>
            <div class=" hover:text-gray-700 ">
                <a href="{{ route('account.show', ['type' => 'change_password']) }}">Change Password</a>
            </div>
        </div>


        {{-- dynamic account page content --}}

        {{-- end of dynamic account page content --}}

    </div>
