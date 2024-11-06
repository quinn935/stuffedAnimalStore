<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = ['name', 'phone', 'email', 'status'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function _getAddresses():HasOne{
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'user_id');
    }

    public function shippingAddress():HasOne{
        return $this->_getAddresses()->where('type', '=', AddressType::Shipping->value);
    }
}
