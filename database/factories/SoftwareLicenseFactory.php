<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\AssetSubclass;
use App\Models\Company;

class SoftwareLicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $maxRelationship = config('constants.MAX_RELATIONSHIPS');
        $assetClassId = rand(1,$maxRelationship);

        return [
            'asset_class_id' => $assetClassId,
            'asset_subclass_id' => function() use ($assetClassId) {
                $AssetSubClass = AssetSubclass::where('asset_class_id', '=', $assetClassId)->get();
                return $AssetSubClass[rand(0,2)]->id;
            },
            'brand_id' => rand(1,$maxRelationship),
            'site_id' => rand(1,$maxRelationship),
            'name' => $this->faker->company,
            'description' => $this->faker->text,
            'po_number_id' => $this->faker->ean13,
            'date_expired' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+5 years', $timezone = date_default_timezone_get()),
            'quantity' => $this->faker->numberBetween($min = 10, $max = 100),
            'isActive' => $this->faker->boolean($chanceOfGettingTrue = 90),
            'availability' => $this->faker->boolean($chanceOfGettingTrue = 95),
            'serial_number' => $this->faker->ean8,
            'asset_number' => $this->faker->ean8,
            'isPEZA' => $this->faker->boolean($chanceOfGettingTrue = 88),
            'isOPEX' => 1,
            'account_type' => 1,
            'sap_code' => $this->faker->ean8,
        ];
    }
}
