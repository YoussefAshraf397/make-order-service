<?php

namespace Domain\Models\Ingredient;

use Astrotomic\Translatable\Translatable;
use Domain\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $table = 'ingredients';

    protected $fillable = [
        'stock_quantity',
    ];

    protected array $translatedAttributes = [
        'name'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredients');
    }
}
