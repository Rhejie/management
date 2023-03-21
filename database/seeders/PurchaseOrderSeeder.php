<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=0;$i<10;$i++)
        {
            PurchaseOrder::firstOrCreate([
                'po_number' => $faker->numerify('########'),
                'date_acquired' => $faker->dateTime(),
                'expiration_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+5 years', $timezone = date_default_timezone_get()),
                'commit' => $faker->boolean($chanceOfGettingTrue = 90),
                'asset_number' => $faker->numerify('############'),
                'serial_number' => $faker->numerify('############'),
                'quantity' => $faker->numberBetween($min = 1, $max = 2000),
                'warranty_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+5 years', $timezone = date_default_timezone_get()),
                'warranty_description' => $faker->text
            ]);
        }
    }
}
