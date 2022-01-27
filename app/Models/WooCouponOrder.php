<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WooCouponOrder extends Model
{
    use HasFactory;
    protected $table = 'woocommerce_coupon_holding';
    protected $guarded = [];
    protected $casts = [
      'item_data' => 'array'
    ];
}
