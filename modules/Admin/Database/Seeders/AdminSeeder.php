<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Admin;

/**
 * Class NewsletterSeeder
 *
 * Seed the application's development database
 */
class AdminSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
