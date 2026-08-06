<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
  protected $fillable = [
    'name',
    'description',
    'price',
    'is_featured',
    'stock',
    'sku',
    'slug',
    'category_id',
  ];

  public function product_purchase_order(): HasMany {
    return $this->hasMany(PurchaseOrder::class, 'product_id');
  }

  public function image(): HasOne {
    return $this->hasOne(Image::class, 'product_id');
  }

  public function category(): BelongsTo {
    return $this->belongsTo(Category::class, 'category_id');
  }

}
