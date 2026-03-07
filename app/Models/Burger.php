<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image_path',
        'description',
        'category',
        'stock_quantity',
        'is_archived',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
