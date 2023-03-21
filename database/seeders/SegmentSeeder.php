<?php

namespace Database\Seeders;

use App\Models\Segment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SegmentSeeder extends Seeder
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
            Segment::firstOrCreate([
                'name' => $faker->company,
            ]);
        }
    }
}
