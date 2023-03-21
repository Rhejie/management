<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CostCenter;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostCenter::firstOrCreate([
            'name' => '01A1050101'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050102'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050103'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050201'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050202'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050301'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050302'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050401'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050501'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050503'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050601'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050202'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050701'
        ]);

        CostCenter::firstOrCreate([
            'name' => '01A1050702'
        ]);
    }
}
