<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';

    protected $fillable = [
        'method_name', 'account_name', 'account_number', 'branch',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
