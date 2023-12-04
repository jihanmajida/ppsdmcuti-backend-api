<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'app_name', 'value' => 'PPSDM CUTI'],
            ['key' => 'app_description', 'value' => ''],
            ['key' => 'app_logo', 'value' => 'public/logo ppsdm-05.png'],
        ];

        foreach ($data as $value) {
            Setting::updateOrCreate([
                'key' => $value['key'],
                'value' => $value['value'],
            ]);
        }
    }
}
