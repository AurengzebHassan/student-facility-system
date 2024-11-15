<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
       'user_id',
       'product_id',
       'order_id',
       'quantity',
       'order_price',
       'archive',
       'image',
       'payment_method_id',
      
    ];
    // public function products(){
    //     return $this->hasMany(Product::class, 'id' , 'product_id');
    // }

    // public function users(){
    //     return $this->hasMany(User::class, 'id' , 'user_id');
    // }
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}
