<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\AssetClass;

class AssetSubClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $AssetClass = AssetClass::inRandomOrder()->first();

        return [
            'asset_class_id' => $AssetClass->id,
            'name' => $this->faker->company,
            'extension' => $this->faker->company,
            'sap_code' => $this->faker->ean8,
        ];
    }
}
