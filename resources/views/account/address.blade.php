<x-app-layout>
    <div class="min-h-screen bg-white">
        @include('account.header')
        <div class="mx-auto max-w-6xl">
            <form action="{{ route('account.store-address') }}" method="POST" class="default-text-color">
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:gap-y-6 lg:gap-x-12 mx-12 lg:mx-8">
                    <div class="">
                        <div class="flex justify-between">
                            <label for="first_name" class="capitalize">First Name</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="first_name" class="w-full mt-1 cyan-ring-input">
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="last_name" class="capitalize">Last Name</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="last_name" class="w-full mt-1 cyan-ring-input">
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="address1" class="capitalize">Address Line 1</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="address1" class="w-full mt-1 cyan-ring-input">
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="address2" class="capitalize">Address Line 2</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="address2" class="w-full mt-1 cyan-ring-input">
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="city" class="capitalize">City</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="city" class="w-full mt-1 cyan-ring-input">
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="state" class="capitalize">State</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <select name="state" class="w-full mt-1 cyan-ring-input">
                            @foreach($usa_states as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="zipcode" class="capitalize">Zipcode</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="zipcode" class="w-full mt-1 cyan-ring-input">
                    </div>
                    <div class="">
                        <div class="flex justify-between">
                            <label for="phone" class="capitalize">Phone</label>
                            <small class="uppercase text-gray-400">required</small>
                        </div>
                        <input type="text" name="phone" class="w-full mt-1 cyan-ring-input">
                    </div>
                </div>
                {{-- form save and cancel buttons --}}
                <div class="flex justify-center items-center py-12 gap-8">
                    <button type="submit" class="primary-btn text-xl">
                        Save address
                    </button>
                    <a href="{{ route('account.show', ['type'=>'address_book']) }}" class="bg-white px-12  py-2 border border-cyan-400 shadow hover:border-black font-semibold text-xl">Cancel</a>
                </div>
                {{-- end of form save and cancel buttons --}}
            </form>
        </div>
    </div>
</x-app-layout>
