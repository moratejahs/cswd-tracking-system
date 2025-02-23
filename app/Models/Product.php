<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'product_name',
        'supplier_name',
        'quantity',
        'unit',
        'sell_price',
        'sell_price_two',
        'cost_price',
        'category_id'
    ];

    public function getProductFullDescAttribute()
    {
        return "{$this->code} - {$this->product_name} - {$this->supplier_name}";
    }

    // Cast the price attribute to cents
    protected function sellPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    protected function sellPriceTwo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    // Cast the price attribute to cents
    protected function costPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
