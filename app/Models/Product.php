<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'stock',
        'is_popular',
        'category_id',
        // 'product_id', di video itu brand_id
    ];

    protected $appends = [
        'thumbnail_url',
    ];

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && $this->thumbnail !== 'product_default.png' && $this->thumbnail !== 'placeholder.png' && $this->thumbnail !== 'product_default.webp') {
            return asset('storage/' . $this->thumbnail);
        }

        $categorySlug = $this->category?->slug ?? 'lain-lain';
        
        $map = [
            'makanan-ringan' => 'snack_placeholder.png',
            'minuman' => 'beverage_placeholder.png',
            'makanan-instan' => 'instant_food_placeholder.png',
            'kebutuhan-rumah-tangga' => 'household_placeholder.png',
            'perawatan-tubuh' => 'body_care_placeholder.png',
            'alat-tulis' => 'stationery_placeholder.png',
            'bahan-rotikue' => 'baking_placeholder.png',
            'bumbu-masakan' => 'spices_placeholder.png',
        ];

        $filename = $map[$categorySlug] ?? 'general_placeholder.png';
        return asset('assets/images/placeholders/' . $filename);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // public function product(): BelongsTo
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // } di video public function brand()

    // public function category(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class, 'category_id');
    // } sebelum di edit

    public function category()
{
    return $this->belongsTo(Category::class);
}


    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

}
