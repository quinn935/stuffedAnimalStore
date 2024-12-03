<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerAddressRequest;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show(Request $request){
        $type = $request->query('type', 'orders');
        $usa_states = config('states');
        $customer_addresses = $request->user()->customer->getAddresses;

        if(str_contains($type, '_')){
            $page_title = str_replace('_', ' ', $type);
        }else{
            $page_title = $type;
        }

        switch($type){
            case 'address_book':
                return view('account.address-book', compact('page_title', 'customer_addresses'));
            case 'address':
                return view('account.address', compact('page_title', 'usa_states'));
            case 'account_details':
                return view('account.account-details', compact('page_title'));
            case 'change_password':
                return view('account.change-password', compact('page_title'));
            case 'orders':
                return view('account.orders', compact('page_title'));
            default:
                return view('account.orders', compact('page_title'));

        }
    }

    public function storeCustomerAddress(CustomerAddressRequest $request){
        $data = $request->validated();
        $user = $request->user();
        $customer = $user->customer;
        $data['customer_id'] = $customer->user_id;
        CustomerAddress::create($data);
        return redirect()->route('account.show', ['type'=>'address_book']);
    }
}
