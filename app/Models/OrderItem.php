<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;
class OrderItem extends Model
{
    use HasFactory;


    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'pid',
        'quantity',
        'price',
    ];

  
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'pid');
    }
}
