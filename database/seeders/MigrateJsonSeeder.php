<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class MigrateJsonSeeder extends Seeder
{
    public function run(): void
    {
        $base = storage_path('app/site');

        // Products
        $productsPath = $base . '/products.json';
        if (is_file($productsPath)) {
            $data = json_decode(file_get_contents($productsPath), true);
            $list = $data['list'] ?? [];
            foreach ($list as $item) {
                Product::create([
                    'name'  => $item['name']  ?? '',
                    'cat'   => $item['cat']   ?? '',
                    'price' => (string)($item['price'] ?? ''),
                    'unit'  => $item['unit']  ?? 'ədəd',
                    'emoji' => $item['emoji'] ?? '📦',
                    'desc'  => $item['desc']  ?? null,
                ]);
            }
            $this->command->info('Imported ' . count($list) . ' products.');

            // Meta-nı saxla (eyebrow/title/sub)
            $meta = $data;
            unset($meta['list']);
            if (!empty($meta)) {
                file_put_contents($base . '/products_meta.json', json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            }
        }

        // Orders
        $ordersPath = $base . '/orders.json';
        if (is_file($ordersPath)) {
            $data = json_decode(file_get_contents($ordersPath), true);
            $list = $data['list'] ?? [];
            foreach ($list as $item) {
                $createdAt = null;
                if (!empty($item['date'])) {
                    try {
                        $createdAt = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $item['date'], 'Asia/Baku');
                    } catch (\Throwable) {
                        $createdAt = now();
                    }
                }
                $row = Order::create([
                    'name'    => $item['name']    ?? '',
                    'phone'   => $item['phone']   ?? '',
                    'email'   => $item['email']   ?? null,
                    'service' => $item['service'] ?? '',
                    'notes'   => $item['notes']   ?? null,
                ]);
                if ($createdAt) {
                    $row->created_at = $createdAt;
                    $row->updated_at = $createdAt;
                    $row->saveQuietly();
                }
            }
            $this->command->info('Imported ' . count($list) . ' orders.');
        }
    }
}
