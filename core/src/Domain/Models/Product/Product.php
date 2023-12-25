<?php

namespace Domain\Models\Product;

use Astrotomic\Translatable\Translatable;
use Domain\Models\Ingredient\Ingredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $table = 'products';

    protected array $translatedAttributes = [
            'name'
    ];
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(
            Ingredient::class,
            'product_ingredients'
        )
            ->withPivot('quantity');
    }
}
