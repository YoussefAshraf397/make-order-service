<?php

namespace Domain\Order\Actions\PlaceOrder;

use Domain\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class GetProductWithIngredientsAction
{
    public function __invoke(int $productId): Model|null
    {
        return Product::query()
            ->with('ingredients.translations')
            ->where('id', $productId)
            ->first();
    }
}
