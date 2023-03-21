<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CostCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $maxRelationship = config('constants.MAX_RELATIONSHIPS');

        return [
            'name' => $this->faker->name,
            'site_id' => rand(1,$maxRelationship),
            'sap_code' => $this->faker->ean8,
        ];
    }
}
