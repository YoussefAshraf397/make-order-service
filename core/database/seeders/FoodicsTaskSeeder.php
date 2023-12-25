<?php

namespace Database\Seeders;

use Domain\Models\Ingredient\Ingredient;
use Domain\Models\Product\Product;
use Domain\Models\Product\ProductIngredient;
use Illuminate\Database\Seeder;

class FoodicsTaskSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Seeding Foddics Task Data...');

        Product::truncate();
        Ingredient::truncate();
        ProductIngredient::truncate();


        $productsData = [
            "product_1" => [
                'id' => '1',
                'en' => "Burger",
                'ar' => "برجر",
            ],
            "product_2" => [
                'id' => '2',
                'en' => "Cheese Burger",
                'ar' => "برجر جبن",
            ],
        ];

        $ingrdientsData = [
            "ingredient_1" => [
                'id' => '1',
                'en' => "Beef",
                'ar' => "لحم",
                'unit' => 'kg',
                'initial_stock' => '20',
                'stock_quantity' => '20',
                'email_sent' => false
            ],
            "ingredient_2" => [
                'id' => '2',
                'en' => "Cheese",
                'ar' => "جبن",
                'unit' => 'kg',
                'initial_stock' => '5',
                'stock_quantity' => '5',
                'email_sent' => false
            ],
            "ingredient_3" => [
                'id' => '3',
                'en' => "Onion",
                'ar' => "بصل",
                'unit' => 'kg',
                'initial_stock' => '1',
                'stock_quantity' => '1',
                'email_sent' => false
            ]
        ];

        $productIngredientsData = [
            "product_1" => [
                "ingredient_1" => [
                    'product_id' => '1',
                    'ingredient_id' => '1',
                    'quantity' => '150',
                    'unit' => 'g',
                ],
                "ingredient_2" => [
                    'product_id' => '1',
                    'ingredient_id' => '2',
                    'quantity' => '30',
                    'unit' => 'g',
                ],
                "ingredient_3" => [
                    'product_id' => '1',
                    'ingredient_id' => '3',
                    'quantity' => '20',
                    'unit' => 'g',
                ]
            ],
            "product_2" => [
                "ingredient_1" => [
                    'product_id' => '2',
                    'ingredient_id' => '1',
                    'quantity' => '200',
                    'unit' => 'g',
                ],
                "ingredient_2" => [
                    'product_id' => '2',
                    'ingredient_id' => '2',
                    'quantity' => '100',
                    'unit' => 'g',
                ],
                "ingredient_3" => [
                    'product_id' => '2',
                    'ingredient_id' => '3',
                    'quantity' => '30',
                    'unit' => 'g',
                ]
            ]
        ];

        foreach ($ingrdientsData as $ingrdientData) {
            $ingredient = Ingredient::create([
                'id' => $ingrdientData['id'],
                'name:en' => $ingrdientData['en'],
                'name:ar' => $ingrdientData['ar'],
                'unit' => $ingrdientData['unit'],
                'initial_stock' => $ingrdientData['initial_stock'],
                'stock_quantity' => $ingrdientData['stock_quantity'],
                'email_sent' => $ingrdientData['email_sent']
            ]);
        }

        foreach ($productsData as $productData) {
            $product = Product::create([
                'id' => $productData['id'],
                'name:en' => $productData['en'],
                'name:ar' => $productData['ar'],
            ]);
        }

        foreach ($productIngredientsData as $productIngredients) {
            foreach ($productIngredients as $productIngredient) {
              ProductIngredient::create([
                'product_id' => $productIngredient['product_id'],
                'ingredient_id' => $productIngredient['ingredient_id'],
                'quantity' => $productIngredient['quantity'],
                'unit' => $productIngredient['unit'],
              ]);
            }
        }
    }
}
