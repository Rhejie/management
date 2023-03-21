<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\AssetSubclass;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $AssetSubclass = AssetSubclass::inRandomOrder()->first();
        
        return [
            'name' => $this->faker->name,
            'asset_subclass_id' => $AssetSubclass->id,
            'sap_code' => $this->faker->ean8,
        ];
    }
}
