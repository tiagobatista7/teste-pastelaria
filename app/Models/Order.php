<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class order extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'product_id',
        'date_create'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->date_create = now();
        });
    }
}
