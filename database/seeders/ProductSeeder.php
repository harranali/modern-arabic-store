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
            [
                'name' => 'هاتف ذكي سامسونج جالاكسي S23 ألترا',
                'slug' => Str::slug('هاتف ذكي سامسونج جالاكسي S23 ألترا', '-'),
                'description' => 'هاتف ذكي متطور بشاشة Dynamic AMOLED قياس 6.8 بوصة، مع معالج Snapdragon 8 Gen 2، وكاميرا رئيسية بدقة 200 ميجابكسل تدعم تصوير ليلي احترافي. يأتي ببطارية تدوم طويلاً مع شحن سريع وميزات الذكاء الاصطناعي المتقدمة.',
                'price' => 1500.00,
                'image' => 'products/phone-1.jpg',
                'category_id' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'حاسوب محمول ماك بوك برو 16 بوصة - شريحة M2 برو',
                'slug' => Str::slug('حاسوب محمول ماك بوك برو 16 بوصة - شريحة M2 برو', '-'),
                'description' => 'حاسوب محمول فائق الأداء مخصص للمحترفين، يتميز بشريحة Apple M2 Pro مع 12 نواة معالجة و 19 نواة رسومية، شاشة Liquid Retina XDR عالية الدقة، ولوحة مفاتيح Magic Keyboard مع إضاءة خلفية. مثالي للمونتاج، التصميم، والبرمجة المتقدمة.',
                'price' => 3000.00,
                'image' => 'products/laptop-1.jpg',
                'category_id' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'ساعة ذكية أبل واتش ألترا - 49 ملم',
                'slug' => Str::slug('ساعة ذكية أبل واتش ألترا - 49 ملم', '-'),
                'description' => 'ساعة ذكية متينة صُممت لعشاق الرياضة والمغامرة. تأتي ببطارية تدوم حتى 36 ساعة، شاشة Retina ساطعة قابلة للعرض تحت الشمس، GPS مزدوج النطاق، وحساسات متقدمة لمتابعة الصحة، معدل ضربات القلب، والأكسجين في الدم. مقاومة للماء حتى 100 متر.',
                'price' => 500.00,
                'image' => 'products/watch-1.jpg',
                'category_id' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'سماعات أذن لاسلكية سوني WF-1000XM5 مع إلغاء الضوضاء',
                'slug' => Str::slug('سماعات أذن لاسلكية سوني WF-1000XM5 مع إلغاء الضوضاء', '-'),
                'description' => 'سماعات أذن بلوتوث صغيرة الحجم بجودة صوت عالية وميزة إلغاء الضوضاء الفعّالة. توفر تجربة استماع نقية مع محركات صوت ديناميكية، ميكروفونات مزدوجة للمكالمات الواضحة، ودعم تقنية LDAC. تدوم البطارية حتى 24 ساعة مع علبة الشحن.',
                'price' => 200.00,
                'image' => 'products/earbuds-1.jpg',
                'category_id' => 4,
                'is_active' => true,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
