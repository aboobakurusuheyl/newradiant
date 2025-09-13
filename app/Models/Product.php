<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'sale_price',
        'category',
        'image',
        'sizes',
        'stock',
        'is_active',
        'is_new',
        'is_sale',
        'sku',
        'features',
    ];

    protected $casts = [
        'sizes' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'is_sale' => 'boolean',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->is_sale && $this->sale_price ? $this->sale_price : $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_sale || !$this->sale_price) {
            return 0;
        }
        
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_sale', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }
}
