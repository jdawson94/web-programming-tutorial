<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    User::factory()

    ->count(1)

    ->create([

    'email' => 'admin@email.com'

    ]);

    User::factory()

    ->count(4)

    ->create();
    }
}
