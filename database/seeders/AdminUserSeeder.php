<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'rufat@technobey.local'],
            [
                'name'     => 'Rufat',
                'password' => Hash::make('totuTbrufuzor26'),
            ],
        );
    }
}
