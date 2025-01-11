<?php

namespace App\Models;
use App\Models\Userr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'uid', 
        'first_name', 
        'last_name', 
        'email', 
        'mobile', 
        'address_line_1', 
        'zip_code', 
        'city', 
        'state', 
        'total'
        
       
    ];

    public function user()
    {
        return $this->belongsTo(Userr::class, 'uid');
    }
    public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}
}
