<?php

namespace App\Models;

use App\Models\Userr;
use App\Models\Product;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $table = 'cart';
    public $primaryKey = 'id';

    public $fillable = [
        'uid',
        'pid',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(Userr::class, 'uid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'pid');
    }
}
