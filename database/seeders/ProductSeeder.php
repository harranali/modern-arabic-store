<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Phones
            [
                'name' => 'هاتف ذكي سامسونج جالاكسي S23 ألترا',
                'slug' => Str::slug('هاتف ذكي سامسونج جالاكسي S23 ألترا', '-'),
                'description' => 'هاتف ذكي متطور بشاشة Dynamic AMOLED قياس 6.8 بوصة، مع معالج Snapdragon 8 Gen 2، وكاميرا رئيسية بدقة 200 ميجابكسل.',
                'price' => 1500.00,
                'image' => 'products/phone-1.jpg',
                'category_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'هاتف ذكي آيفون 15 برو ماكس',
                'slug' => Str::slug('هاتف ذكي آيفون 15 برو ماكس', '-'),
                'description' => 'آيفون 15 برو ماكس مع شاشة Super Retina XDR، معالج A17 Bionic، وكاميرا ثلاثية لتصوير احترافي.',
                'price' => 1800.00,
                'image' => 'products/phone-2.jpg',
                'category_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'هاتف ذكي شاومي 13 برو',
                'slug' => Str::slug('هاتف ذكي شاومي 13 برو', '-'),
                'description' => 'هاتف شاومي 13 برو بشاشة AMOLED، كاميرا رئيسية 200 ميجابكسل، وميزة الشحن السريع 120 واط.',
                'price' => 1200.00,
                'image' => 'products/phone-3.jpg',
                'category_id' => 1,
                'is_active' => true,
            ],

            // Laptops
            [
                'name' => 'حاسوب محمول ماك بوك برو 16 بوصة - شريحة M2 برو',
                'slug' => Str::slug('حاسوب محمول ماك بوك برو 16 بوصة - شريحة M2 برو', '-'),
                'description' => 'حاسوب محمول فائق الأداء مخصص للمحترفين، مع شريحة Apple M2 Pro وشاشة Liquid Retina XDR.',
                'price' => 3000.00,
                'image' => 'products/laptop-1.jpg',
                'category_id' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'حاسوب محمول ديل XPS 13',
                'slug' => Str::slug('حاسوب محمول ديل XPS 13', '-'),
                'description' => 'ديل XPS 13 مع شاشة InfinityEdge بدقة 4K، معالج Intel Core i7، وذاكرة وصول عشوائي 16 جيجابايت.',
                'price' => 2000.00,
                'image' => 'products/laptop-2.jpg',
                'category_id' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'حاسوب محمول لينوفو ثينك باد X1 كاربوك',
                'slug' => Str::slug('حاسوب محمول لينوفو ثينك باد X1 كاربوك', '-'),
                'description' => 'لينوفو X1 Carbon خفيف الوزن، أداء قوي مع معالج Intel i7 وذاكرة تخزين SSD 1 تيرابايت.',
                'price' => 1800.00,
                'image' => 'products/laptop-3.jpg',
                'category_id' => 2,
                'is_active' => true,
            ],

            // Watches
            [
                'name' => 'ساعة ذكية أبل واتش ألترا - 49 ملم',
                'slug' => Str::slug('ساعة ذكية أبل واتش ألترا - 49 ملم', '-'),
                'description' => 'ساعة ذكية متينة لعشاق الرياضة، شاشة Retina قابلة للعرض تحت الشمس، GPS مزدوج، مقاومة للماء حتى 100 متر.',
                'price' => 500.00,
                'image' => 'products/watch-1.jpg',
                'category_id' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'ساعة سامسونج جالاكسي واتش 6',
                'slug' => Str::slug('ساعة سامسونج جالاكسي واتش 6', '-'),
                'description' => 'ساعة ذكية مع شاشة Super AMOLED، تتبع النوم والنشاط الرياضي، مقاومة للماء حتى 50 متر.',
                'price' => 350.00,
                'image' => 'products/watch-2.jpg',
                'category_id' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'ساعة فيت بيت سينس 2',
                'slug' => Str::slug('ساعة فيت بيت سينس 2', '-'),
                'description' => 'ساعة صحية ذكية مع تتبع معدل ضربات القلب، مستوى التوتر، ونوم متقدم، بطارية تدوم حتى 10 أيام.',
                'price' => 250.00,
                'image' => 'products/watch-3.jpg',
                'category_id' => 3,
                'is_active' => true,
            ],

            // Earbuds
            [
                'name' => 'سماعات أذن لاسلكية سوني WF-1000XM5 مع إلغاء الضوضاء',
                'slug' => Str::slug('سماعات أذن لاسلكية سوني WF-1000XM5 مع إلغاء الضوضاء', '-'),
                'description' => 'سماعات بلوتوث صغيرة الحجم بجودة صوت عالية وميزة إلغاء الضوضاء، تدوم البطارية حتى 24 ساعة.',
                'price' => 200.00,
                'image' => 'products/earbuds-1.jpg',
                'category_id' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'سماعات أذن آبل AirPods Pro الجيل الثاني',
                'slug' => Str::slug('سماعات أذن آبل AirPods Pro الجيل الثاني', '-'),
                'description' => 'سماعات لاسلكية مع ميزة إلغاء الضوضاء النشطة، جودة صوت محسنة، وعمر بطارية طويل.',
                'price' => 250.00,
                'image' => 'products/earbuds-2.jpg',
                'category_id' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'سماعات أذن Bose QuietComfort اللاسلكية',
                'slug' => Str::slug('سماعات أذن Bose QuietComfort اللاسلكية', '-'),
                'description' => 'سماعات ذات جودة صوت عالية مع ميزة إلغاء الضوضاء النشطة، مناسبة للاستماع لفترات طويلة.',
                'price' => 220.00,
                'image' => 'products/earbuds-3.jpg',
                'category_id' => 4,
                'is_active' => true,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
