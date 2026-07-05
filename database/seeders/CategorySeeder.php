<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['slug' => 'komputer',  'name' => 'Kompüterlər',  'icon' => '💻', 'sort_order' => 1],
            ['slug' => 'printer',   'name' => 'Printerlər',   'icon' => '🖨️', 'sort_order' => 2],
            ['slug' => 'proyektor', 'name' => 'Proyektorlar', 'icon' => '📽️', 'sort_order' => 3],
            ['slug' => 'aksesuar',  'name' => 'Aksesuarlar',  'icon' => '🖱️', 'sort_order' => 4],
        ];
        foreach ($items as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
