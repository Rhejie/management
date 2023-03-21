<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProponentType;

class ProponentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProponentType::firstOrCreate([
            'type' => 'Employee'
        ]);
        ProponentType::firstOrCreate([
            'type' => 'Campaign'
        ]);
        ProponentType::firstOrCreate([
            'type' => 'Site'
        ]);
        // ProponentType::firstOrCreate([
        //     'type' => 'Hardware'
        // ]);
    }
}
