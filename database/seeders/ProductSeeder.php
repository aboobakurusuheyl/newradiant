<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'New Radiant Home Jersey 2024',
                'description' => 'Official home jersey with club crest and sponsor logos. Made from premium moisture-wicking fabric.',
                'price' => 45.00,
                'sale_price' => 35.00,
                'category' => 'jerseys',
                'image' => 'jersey.jpg',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'stock' => 50,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => true,
                'sku' => 'NR-HJ-2024-001',
                'features' => '100% Polyester, Moisture-wicking, Machine washable, Official club crest'
            ],
            [
                'name' => 'New Radiant Away Jersey 2024',
                'description' => 'Official away jersey in classic white and blue. Perfect for away matches and training.',
                'price' => 45.00,
                'sale_price' => null,
                'category' => 'jerseys',
                'image' => 'jersey2.png',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'stock' => 30,
                'is_active' => true,
                'is_new' => true,
                'is_sale' => false,
                'sku' => 'NR-AJ-2024-001',
                'features' => '100% Polyester, Breathable fabric, Machine washable, Official club crest'
            ],
            [
                'name' => 'New Radiant Training Kit',
                'description' => 'Complete training kit for academy players. Includes jersey, shorts, and socks.',
                'price' => 35.00,
                'sale_price' => null,
                'category' => 'jerseys',
                'image' => 'team.jpg',
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'stock' => 25,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-TK-2024-001',
                'features' => 'Complete kit, Training specific design, Comfortable fit, Academy approved'
            ],
            [
                'name' => 'New Radiant Cap',
                'description' => 'Adjustable cap with embroidered club logo. Perfect for sunny match days.',
                'price' => 20.00,
                'sale_price' => 15.00,
                'category' => 'accessories',
                'image' => 'hat.png',
                'sizes' => ['One Size'],
                'stock' => 75,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => true,
                'sku' => 'NR-CP-2024-001',
                'features' => 'Adjustable strap, Embroidered logo, UV protection, Machine washable'
            ],
            [
                'name' => 'New Radiant Cap (Alternative)',
                'description' => 'Alternative cap design with club colors. Show your support in style.',
                'price' => 18.00,
                'sale_price' => null,
                'category' => 'accessories',
                'image' => 'hat2.png',
                'sizes' => ['One Size'],
                'stock' => 60,
                'is_active' => true,
                'is_new' => true,
                'is_sale' => false,
                'sku' => 'NR-CP-2024-002',
                'features' => 'Alternative design, Club colors, Comfortable fit, Machine washable'
            ],
            [
                'name' => 'New Radiant Water Bottle',
                'description' => 'Insulated water bottle with club colors. Stay hydrated during training.',
                'price' => 18.00,
                'sale_price' => null,
                'category' => 'equipment',
                'image' => 'bottle.png',
                'sizes' => [],
                'stock' => 60,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-WB-2024-001',
                'features' => 'Insulated, Club colors, BPA-free, Leak-proof'
            ],
            [
                'name' => 'New Radiant Champions Collection',
                'description' => 'Special edition items celebrating our championship victories. Limited collection.',
                'price' => 30.00,
                'sale_price' => 25.00,
                'category' => 'merchandise',
                'image' => 'champ.jpg',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'stock' => 40,
                'is_active' => true,
                'is_new' => true,
                'is_sale' => true,
                'sku' => 'NR-CC-2024-001',
                'features' => 'Limited edition, Championship design, Premium quality, Collectible'
            ],
            [
                'name' => 'New Radiant Team Photo',
                'description' => 'Official team photo print. Perfect for framing and displaying your support.',
                'price' => 15.00,
                'sale_price' => null,
                'category' => 'merchandise',
                'image' => 'im2.jpg',
                'sizes' => ['8x10', '11x14', '16x20'],
                'stock' => 100,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-TP-2024-001',
                'features' => 'High quality print, Various sizes, Frame ready, Official team photo'
            ],
            [
                'name' => 'New Radiant Scarf',
                'description' => 'Official club scarf for match days. Show your support with pride.',
                'price' => 15.00,
                'sale_price' => null,
                'category' => 'accessories',
                'image' => 'image.jpg',
                'sizes' => [],
                'stock' => 100,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-SC-2024-001',
                'features' => '100% Acrylic, Soft and warm, Club colors, Machine washable'
            ],
            [
                'name' => 'New Radiant Keychain',
                'description' => 'Metal keychain with club crest. A perfect small gift for any fan.',
                'price' => 8.00,
                'sale_price' => null,
                'category' => 'accessories',
                'image' => 'img.jpg',
                'sizes' => [],
                'stock' => 200,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-KC-2024-001',
                'features' => 'Metal construction, Club crest, Durable, Lightweight'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
