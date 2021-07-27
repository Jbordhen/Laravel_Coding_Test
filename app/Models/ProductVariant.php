<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
  public function product_variant_prices()
  {
    return $this->hasMany(ProductVariantPrice::class);
  }
}
