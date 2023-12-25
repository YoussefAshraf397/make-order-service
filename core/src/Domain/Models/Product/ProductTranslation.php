<?php

namespace Domain\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTranslation extends Model
{
    use SoftDeletes;

    protected $table = 'product_translations';

    protected $fillable = [
        'name',
    ];
}
