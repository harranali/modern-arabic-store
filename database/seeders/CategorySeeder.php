<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'هواتف ذكية',
                'slug' => Str::slug('هواتف ذكية', '-'),
                'description' => 'كل أنواع الهواتف الذكية الحديثة',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'حاسوب محمول',
                'slug' => Str::slug('حاسوب محمول', '-'),
                'description' => 'أجهزة الحاسوب المحمولة عالية الأداء',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'ساعات ذكية',
                'slug' => Str::slug('ساعات ذكية', '-'),
                'description' => 'ساعات ذكية لمتابعة الصحة واللياقة',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'سماعات',
                'slug' => Str::slug('سماعات', '-'),
                'description' => 'سماعات أذن وسماعات رأس عالية الجودة',
                'is_active' => true,
            ],
        ];


        DB::table('categories')->insert($categories);
    }
}
