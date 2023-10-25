<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Item::factory(10)->create();

        \App\Models\Customer::factory()->create([
            'email' => 'test@test.com',
            'first_name' =>'test',
            'last_name' =>'customer',
            'store_credit' => 1000,
        ]);
    }
}
