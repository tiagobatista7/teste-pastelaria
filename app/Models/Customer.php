<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'address',
        'complement',
        'neighborhood',
        'zip_code',
        'register_date'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            $customer->register_date = now();
        });
    }
}
