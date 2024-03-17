<?php

namespace Modules\Purchase\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'quantity',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
