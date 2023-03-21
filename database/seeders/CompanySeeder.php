<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::firstOrCreate([
            'name' => 'Inspiro',
            'cost_center' => Str::random(8),
            'company_code' => '1001'
        ]);

        Company::firstOrCreate([
            'name' => 'Infocom Technologies',
            'cost_center' => Str::random(8),
            'company_code' => '1102'
        ]);

        Company::firstOrCreate([
            'name' => 'CRM US',
            'cost_center' => Str::random(8),
            'company_code' => '1005'
        ]);

        Company::firstOrCreate([
            'name' => 'SPI Global - Nicaragua',
            'cost_center' => Str::random(8),
            'company_code' => '1003'
        ]);

        Company::firstOrCreate([
            'name' => 'Relia Global Shared Services - ROHQ',
            'cost_center' => Str::random(8),
            'company_code' => '1204'
        ]);
    }
}
