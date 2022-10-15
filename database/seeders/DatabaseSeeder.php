<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;

use Database\Seeders\VisitorSeeder;
use Database\Seeders\UserSeeder;


class DatabaseSeeder extends Seeder

{

public function run()

{

$this->call([

VisitorSeeder::class,
UserSeeder::class

]);

}

}