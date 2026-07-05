<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['slug' => 'komputer',  'name_az' => 'Kompüterlər', 'name_en' => 'Computers',   'name_ru' => 'Компьютеры',  'icon' => '💻', 'sort_order' => 1],
            ['slug' => 'printer',   'name_az' => 'Printerlər',  'name_en' => 'Printers',    'name_ru' => 'Принтеры',    'icon' => '🖨️', 'sort_order' => 2],
            ['slug' => 'proyektor', 'name_az' => 'Proyektorlar','name_en' => 'Projectors',  'name_ru' => 'Проекторы',   'icon' => '📽️', 'sort_order' => 3],
            ['slug' => 'aksesuar',  'name_az' => 'Aksesuarlar', 'name_en' => 'Accessories', 'name_ru' => 'Аксессуары',  'icon' => '🖱️', 'sort_order' => 4],
        ];
        foreach ($items as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
