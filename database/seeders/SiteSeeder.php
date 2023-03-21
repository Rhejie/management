<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code = Str::random(8);
        
        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1150101',
            'name' => 'ADB',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1150102',
            'name' => 'ADB',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1150201',
            'name' => 'ADB',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1150301',
            'name' => 'ADB',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1150502',
            'name' => 'ADB',
        ]);

        $code = Str::random(8);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1010101',
            'name' => 'Cyberscape',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1010102',
            'name' => 'Cyberscape',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1010103',
            'name' => 'Cyberscape',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1010201',
            'name' => 'Cyberscape',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1010202',
            'name' => 'Cyberscape',
        ]);

        $code = Str::random(8);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1140101',
            'name' => 'Cyberscape Beta',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1140102',
            'name' => 'Cyberscape Beta',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1140201',
            'name' => 'Cyberscape Beta',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1140301',
            'name' => 'Cyberscape Beta',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1140103',
            'name' => 'Cyberscape Beta',
        ]);

        $code = Str::random(8);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1020101',
            'name' => 'Dumaguete',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1020102',
            'name' => 'Dumaguete',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1020103',
            'name' => 'Dumaguete',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1020201',
            'name' => 'Dumaguete',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01A1020202',
            'name' => 'Dumaguete',
        ]);

        $code = Str::random(8);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01ZZ001701',
            'name' => 'Head Office',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01D1000501',
            'name' => 'Head Office',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01C1000012',
            'name' => 'Head Office',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01E1000703',
            'name' => 'Head Office',
        ]);

        Site::firstOrCreate([
            'company_code' => '1001',
            'site_code' => $code,
            'cost_center' => '01H1000501',
            'name' => 'Head Office',
        ]);

        $code = Str::random(8);

        Site::firstOrCreate([
            'company_code' => '1102',
            'site_code' => $code,
            'cost_center' => '02ZZ001701',
            'name' => 'ICOM',
        ]);

        Site::firstOrCreate([
            'company_code' => '1102',
            'site_code' => $code,
            'cost_center' => '02ZZ001211',
            'name' => 'ICOM',
        ]);

        Site::firstOrCreate([
            'company_code' => '1102',
            'site_code' => $code,
            'cost_center' => '02A1010101',
            'name' => 'ICOM',
        ]);

        Site::firstOrCreate([
            'company_code' => '1102',
            'site_code' => $code,
            'cost_center' => '02A1010102',
            'name' => 'ICOM',
        ]);

        Site::firstOrCreate([
            'company_code' => '1102',
            'site_code' => $code,
            'cost_center' => '02A1010103',
            'name' => 'ICOM',
        ]);
    }
}
