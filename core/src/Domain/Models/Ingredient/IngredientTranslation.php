<?php

namespace Domain\Models\Ingredient;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientTranslation extends Model
{
    use SoftDeletes;

    protected $table = 'ingredients_translations';

    protected $fillable = [
        'name',
    ];
}
