<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variations = [
            1001 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 790.00,
                    'selling_price' => 950.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Blue',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 850.00,
                    'selling_price' => 999.99,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Red',
                    'variation_type' => 'Storage',
                    'variation_value' => '512GB',
                    'purchase_price' => 920.00,
                    'selling_price' => 1050.00,
                    'status' => 'Active',
                ],
            ],
            1002 => [
                [
                    'color' => 'White',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 740.00,
                    'selling_price' => 899.99,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 780.00,
                    'selling_price' => 950.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Pink',
                    'variation_type' => 'Storage',
                    'variation_value' => '512GB',
                    'purchase_price' => 850.00,
                    'selling_price' => 1050.00,
                    'status' => 'Active',
                ],
            ],
            1003 => [
                [
                    'color' => 'Just Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 740.00,
                    'selling_price' => 850.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Snow',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 800.00,
                    'selling_price' => 950.00,
                    'status' => 'Active',
                ],
            ],
            1004 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 690.00,
                    'selling_price' => 729.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Green',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 740.00,
                    'selling_price' => 799.00,
                    'status' => 'Active',
                ],
            ],
            1005 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 780.00,
                    'selling_price' => 849.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Blue',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 820.00,
                    'selling_price' => 899.00,
                    'status' => 'Active',
                ],
            ],
            1006 => [
                [
                    'color' => 'White',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 660.00,
                    'selling_price' => 699.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Blue',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 700.00,
                    'selling_price' => 749.00,
                    'status' => 'Active',
                ],
            ],
            1007 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 530.00,
                    'selling_price' => 599.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Blue',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 560.00,
                    'selling_price' => 629.00,
                    'status' => 'Active',
                ],
            ],
            1008 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Storage',
                    'variation_value' => '128GB',
                    'purchase_price' => 420.00,
                    'selling_price' => 499.00,
                    'status' => 'Active',
                ],
                [
                    'color' => 'Blue',
                    'variation_type' => 'Storage',
                    'variation_value' => '256GB',
                    'purchase_price' => 460.00,
                    'selling_price' => 549.00,
                    'status' => 'Active',
                ],
            ],
            1009 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Size',
                    'variation_value' => '55"',
                    'purchase_price' => 650.00,
                    'selling_price' => 699.99,
                    'status' => 'Active',
                ],
            ],
            1010 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Type',
                    'variation_value' => 'Noise-canceling',
                    'purchase_price' => 250.00,
                    'selling_price' => 299.99,
                    'status' => 'Active',
                ],
            ],
            1011 => [
                [
                    'color' => 'Purple',
                    'variation_type' => 'Type',
                    'variation_value' => 'Cordless',
                    'purchase_price' => 540.00,
                    'selling_price' => 599.00,
                    'status' => 'Active',
                ],
            ],
            1012 => [
                [
                    'color' => 'White',
                    'variation_type' => 'Type',
                    'variation_value' => 'Electric',
                    'purchase_price' => 75.00,
                    'selling_price' => 89.99,
                    'status' => 'Active',
                ],
            ],
            1013 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Lens',
                    'variation_value' => 'Standard',
                    'purchase_price' => 3200.00,
                    'selling_price' => 3799.00,
                    'status' => 'Active',
                ],
            ],
            1014 => [
                [
                    'color' => 'Silver',
                    'variation_type' => 'Type',
                    'variation_value' => 'Wireless',
                    'purchase_price' => 300.00,
                    'selling_price' => 349.00,
                    'status' => 'Active',
                ],
            ],
            1015 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Type',
                    'variation_value' => 'Fitness Tracker',
                    'purchase_price' => 110.00,
                    'selling_price' => 129.99,
                    'status' => 'Active',
                ],
            ],
            1016 => [
                [
                    'color' => 'Silver',
                    'variation_type' => 'Type',
                    'variation_value' => 'Stand Mixer',
                    'purchase_price' => 350.00,
                    'selling_price' => 399.00,
                    'status' => 'Active',
                ],
            ],
            1017 => [
                [
                    'color' => 'Black',
                    'variation_type' => 'Type',
                    'variation_value' => 'DSLR',
                    'purchase_price' => 750.00,
                    'selling_price' => 849.99,
                    'status' => 'Active',
                ],
            ],
        ];

        foreach ($variations as $sku => $variationData) {
            $product = Product::where('sku', $sku)->first();
            if ($product) {
                foreach ($variationData as $variation) {
                    ProductVariation::create([
                        'product_id' => $product->id,
                        'color' => $variation['color'],
                        'variation_type' => $variation['variation_type'],
                        'variation_value' => $variation['variation_value'],
                        'purchase_price' => $variation['purchase_price'],
                        'selling_price' => $variation['selling_price'],
                        'status' => $variation['status'],
                    ]);
                }
            }
        }
    }
}
