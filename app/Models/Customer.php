<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'first_name', 'last_name', 'phone', 'email', 'status', 'password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAddresses():HasMany{
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'user_id');
    }

    public function shippingAddress():HasOne{
        return $this->getAddresses()->where('type', '=', AddressType::Shipping->value);
    }
}
