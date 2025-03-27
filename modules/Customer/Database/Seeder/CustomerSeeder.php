<?php

namespace Modules\Customer\Database\Seeder;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Models\Customer;

/**
 * Class CustomerSeeder
 *
 * Seed the application's development database
 */
class CustomerSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $customer = Customer::factory()->create([
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
