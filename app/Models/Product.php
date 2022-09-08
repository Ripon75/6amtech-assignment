<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'original_price',
        'selling_price',
        'tax',
        'quantity',
        'status',
        'image',
        'description'
    ];

    protected $casts = [
        'name'           => 'string',
        'slug'           => 'string',
        'category_id'    => 'integer',
        'brand_id'       => 'integer',
        'original_price' => 'decimal:2',
        'selling_price'  => 'decimal:2',
        'tax'            => 'decimal:2',
        'quantity'       => 'integer',
        'status'         => 'string',
        'image'          => 'string',
        'description'    => 'string',
        'created_at'     => 'datetime:Y-m-d H:i:s',
        'updated_at'     => 'datetime:Y-m-d H:i:s'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function scopePriceRageWiseFilter($query, $startPrice, $endPrice)
    {
        if ($startPrice && $endPrice) {
            $query->whereBetween('price', [$startPrice, $endPrice]);
        }
    }
}
