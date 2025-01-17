<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    // The attributes that are mass assignable
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
    ];

      public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
