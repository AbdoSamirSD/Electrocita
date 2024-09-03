<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Abdo Samir',
            'email' => 'admin@electrocita.com',
            'password' => bcrypt('Abdo@123'),
            ]);
    }
}
