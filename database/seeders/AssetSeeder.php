<?php

namespace Database\Seeders;

use App\Models\BrandModel;
use App\Models\Company;
use App\Models\PurchaseOrder;
use App\Models\Segment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Controllers\Api\BrandModelController;
use App\Http\Resources\BrandModelResource;

class AssetSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AssetClassSeeder::class,
            BrandSeeder::class,
        ]);

        $segments = ['A - Software License','B - Physical Assets','C - Consumables'];

        foreach($segments as $segment)
            Segment::create(['name' => $segment]);

        $faker = Faker::create();

        for($i=0;$i<10;$i++) //1 item per po
        {
            $po_number = $faker->numerify('########');
            $dateAcquired = $faker->date($format = 'Y-m-d', $max = 'now');
            $expDate = $faker->dateTimeBetween($startDate = 'now', $endDate = '+5 years', $timezone = date_default_timezone_get());
            $warrantyDate = $faker->dateTimeBetween($startDate = 'now', $endDate = $expDate->format('Y-m-d'), $timezone = date_default_timezone_get());
            $brand_model_id = BrandModel::inRandomOrder()->first()->id;

            $purchaseOrder = PurchaseOrder::create([
                'company_id' => Company::inRandomOrder()->first()->id,
                'brand_model_id' => $brand_model_id,
                'po_number' => $po_number,
                'date_acquired' => $dateAcquired,
                'expiration_date' => $expDate,
                'asset_value' => $faker->randomFloat($nbMaxDecimals = 2,$min = 1500, $max = 10000),
                'accounting_value' => $faker->randomFloat($nbMaxDecimals = 2,$min = 1000, $max = 5000),
                'accumulated_depreciation' =>$faker->randomFloat($nbMaxDecimals = 2,$min = 800, $max = 4000),
                'isPEZA' => $faker->boolean($chanceOfGettingTrue = 80),
                'lifespan' => $faker->numberBetween($min = 5, $max = 12),
                'account_type' => $faker->boolean($chanceOfGettingTrue = 99),
                'serial_number' => $faker->numerify('############'),
                'warranty_date' => $warrantyDate,
                'warranty_description' => $faker->text,
                'quantity' => $faker->numberBetween($min = 800, $max = 2000),
            ]);

            $BrandModelController = new BrandModelController;
            $brandModelSummary = $BrandModelController->brandModelSummary($brand_model_id);

            if ($brandModelSummary->asset_class->asset_type_id == 0) {
                $purchaseOrder->softwareLicenses()->firstOrCreate([
                    'brand_model_id' => $brand_model_id,
                    'segment_id' => Segment::inRandomOrder()->first()->id,
                    'disposal' => 0,
                    'isActive' => 1,
                ]);
            }else {
                $purchaseOrder->physicalAssets()->firstOrCreate([
                    'brand_model_id' => $brand_model_id,
                    'po_number_id' => $purchaseOrder->id,
                    'segment_id' => Segment::inRandomOrder()->first()->id,
                    'disposal' => 0,
                    'isActive' => 1,
                ]);
            }
        }
    }
}
