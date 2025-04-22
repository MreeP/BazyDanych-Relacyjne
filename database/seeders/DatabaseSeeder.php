<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\AdminSeeder;
use Modules\Customer\Database\Seeder\CustomerSeeder;
use Modules\Post\Database\Seeders\PostSeeder;

/**
 * Class DatabaseSeeder
 *
 * Seed the application's database.
 */
class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            PostSeeder::class
        ]);
    }
}
