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
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop',
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'stock' => 25,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-TK-2024-001',
                'features' => 'Complete kit, Training specific design, Comfortable fit, Academy approved'
            ],
            [
                'name' => 'New Radiant Scarf',
                'description' => 'Official club scarf for match days. Show your support with pride.',
                'price' => 15.00,
                'sale_price' => null,
                'category' => 'accessories',
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=400&fit=crop',
                'sizes' => [],
                'stock' => 100,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-SC-2024-001',
                'features' => '100% Acrylic, Soft and warm, Club colors, Machine washable'
            ],
            [
                'name' => 'New Radiant Cap',
                'description' => 'Adjustable cap with embroidered club logo. Perfect for sunny match days.',
                'price' => 20.00,
                'sale_price' => 15.00,
                'category' => 'accessories',
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400&h=400&fit=crop',
                'sizes' => ['One Size'],
                'stock' => 75,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => true,
                'sku' => 'NR-CP-2024-001',
                'features' => 'Adjustable strap, Embroidered logo, UV protection, Machine washable'
            ],
            [
                'name' => 'New Radiant Keychain',
                'description' => 'Metal keychain with club crest. A perfect small gift for any fan.',
                'price' => 8.00,
                'sale_price' => null,
                'category' => 'accessories',
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=400&fit=crop',
                'sizes' => [],
                'stock' => 200,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-KC-2024-001',
                'features' => 'Metal construction, Club crest, Durable, Lightweight'
            ],
            [
                'name' => 'New Radiant Football',
                'description' => 'Official match ball with club branding. Perfect for training and matches.',
                'price' => 25.00,
                'sale_price' => null,
                'category' => 'equipment',
                'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop',
                'sizes' => [],
                'stock' => 40,
                'is_active' => true,
                'is_new' => true,
                'is_sale' => false,
                'sku' => 'NR-FB-2024-001',
                'features' => 'Official size, Club branding, High quality leather, Match approved'
            ],
            [
                'name' => 'New Radiant Water Bottle',
                'description' => 'Insulated water bottle with club colors. Stay hydrated during training.',
                'price' => 18.00,
                'sale_price' => null,
                'category' => 'equipment',
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=400&fit=crop',
                'sizes' => [],
                'stock' => 60,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-WB-2024-001',
                'features' => 'Insulated, Club colors, BPA-free, Leak-proof'
            ],
            [
                'name' => 'New Radiant Mug',
                'description' => 'Ceramic mug with club logo and colors. Perfect for your morning coffee.',
                'price' => 12.00,
                'sale_price' => null,
                'category' => 'merchandise',
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=400&fit=crop',
                'sizes' => [],
                'stock' => 80,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-MG-2024-001',
                'features' => 'Ceramic construction, Club logo, Microwave safe, Dishwasher safe'
            ],
            [
                'name' => 'New Radiant Sticker Pack',
                'description' => 'Set of 10 vinyl stickers with club designs. Decorate your belongings.',
                'price' => 5.00,
                'sale_price' => null,
                'category' => 'merchandise',
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=400&fit=crop',
                'sizes' => [],
                'stock' => 150,
                'is_active' => true,
                'is_new' => false,
                'is_sale' => false,
                'sku' => 'NR-SP-2024-001',
                'features' => 'Vinyl stickers, Weather resistant, Various designs, Easy to apply'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
