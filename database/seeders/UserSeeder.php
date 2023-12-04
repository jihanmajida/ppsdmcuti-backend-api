<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user = User::where('email', 'admin@gmail.com')->first();

          if (!$default_user) {
             User::updateOrCreate([
              'name' => 'Admin',
              'email' => 'admin@gmail.com',
              'password' => Hash::make('admin123'),
              'role' => 'admin',
         ]); 
        }
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
        ]);
    }
}
