<?php

namespace Database\Seeders;

use App\Models\AssetClass;
use App\Models\AssetSubclass;
use Illuminate\Database\Seeder;

class AssetClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $maxRelationship = config('constants.MAX_RELATIONSHIPS');

        // AssetClass::factory($maxRelationship)->create()->each(function($assetClass) {
        //     AssetSubclass::factory(3)->create([
        //         'asset_class_id' => $assetClass->id,
        //     ]);
        // });
        $classes = [
            ['asset_type_id' => 0, 'name' => 'Subscription', 'subclasses' => ['Productivity Tool','Systems-Related & Programming']],
            // ['asset_type_id' => 0, 'name' => 'Named License', 'subclasses' => ['Network Security','Network-Related','Productivity Tool','Programming','Systems-Related','Systems-Related & Programming']],
            // ['asset_type_id' => 0, 'name' => 'On Premise', 'subclasses' => ['Network Security','Network-Related','Productivity Tool','Programming','Systems-Related','Systems-Related & Programming']],
            ['asset_type_id' => 0, 'name' => 'Fixed License', 'subclasses' => ['Programming','Systems-Related']],
            ['asset_type_id' => 1, 'name' => 'Furniture & Fixtures', 'subclasses' => []],
            ['asset_type_id' => 1, 'name' => 'Computer / Desktop', 'subclasses' => []],
            ['asset_type_id' => 1, 'name' => 'Data Networking Equipment', 'subclasses' => ['Routers']],
            ['asset_type_id' => 1, 'name' => 'Leasehold Improvements', 'subclasses' => []],
            ['asset_type_id' => 1, 'name' => 'Office Equipment', 'subclasses' => []],
            ['asset_type_id' => 1, 'name' => 'Telephone Equipment', 'subclasses' => []],
        ];
        
        foreach($classes as $class)
        {
            $AssetClass = AssetClass::create([
                'asset_type_id' => $class['asset_type_id'],
                'name' => $class['name'],
            ]);

            foreach($class['subclasses'] as $subclass)
            {
                AssetSubclass::create([
                    'asset_class_id' => $AssetClass->id,
                    'name' => $subclass
                ]);
            }
        }

        //AssetClass::factory($maxRelationship)->create();
    }
}
