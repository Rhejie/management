<?php

namespace Database\Seeders;

use App\Models\AssetSubclass;
use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Brand::factory(config('constants.MAX_RELATIONSHIPS'))->create();
        // $faker = \Faker\Factory::create();
        // $maxRelationship = config('constants.MAX_RELATIONSHIPS');
        // Brand::factory($maxRelationship)->create()->each(function($brand) use($faker) {
        //     // $assetClass->subClasses()->saveMany(AssetSubclass::factory(rand(1,3))->create(['asset_class_id' => $assetClass->id]));
        //     for($i=1;$i<=5;$i++)
        //     {
        //         BrandModel::create([
        //             'brand_id' => $brand->id,
        //             'name' => $faker->name,
        //             'description' => $faker->name,
        //         ]);
        //     }
        // });
        $brands = [
            [
                'name' => 'Microsoft',
                'subclass' => 'Productivity Tool',
                'brand_models' => [
                    ['name' => 'EXCHANGE SERVER ENTERPRISES 2016', 'other_name' => 'EXCHANGE SERVER ENTERPRISES 2016', 'description' => 'MICROSOFT EXCHANGE SERVER ENTERPRISES 2016'],
                    ['name' => 'OFFICE STANDARD 2016', 'other_name' => 'OFFICE STANDARD 2016', 'description' => 'MICROSOFT OFFICE STANDARD 2016'],
                    ['name' => 'Office Professional Plus 2019', 'other_name' => 'Office Professional Plus 2019', 'description' => 'MICROSOFT OFFICE PROFESSIONAL PLUS 2019'],
                    ['name' => 'Skype for Business 2019', 'other_name' => 'Skype for Business 2019', 'description' => 'MICROSOFT SKYPE FOR BUSINESS 2019']
                ]
            ],
            [
                'name' => 'Cisco',
                'subclass' => 'Routers',
                'brand_models' => [
                    ['name' => 'ENCS 5100 model', 'other_name' => 'ENCS 5100', 'description' => 'The 5100 Series is a fully virtualized platform for NFV Ethernet deployments.'],
                    ['name' => 'ENCS 5400 model', 'other_name' => 'ENCS 5400', 'description' => 'The 5400 Series includes extensive options for compute, connectivity, storage, and power.'],
                    ['name' => 'Cisco 900 Series Integrated Services Routers', 'other_name' => 'Cisco 900', 'description' => 'Cisco 900 Series Integrated Services Routers (ISRs) combine WAN, switching, security, and advanced connectivity options in a compact, fanless platform.'],
                ]
            ],
            [
                'name' => 'Jet Brains', 
                'subclass' => 'Programming',
                'brand_models' => [
                    ['name' => 'PhpStorm', 'other_name' => 'PhpStorm', 'description' => 'PhpStorm is perfect for working with Symfony, Laravel, Drupal, WordPress, Zend Framework, Magento, Joomla!, CakePHP, Yii, and other frameworks.'],
                    ['name' => 'RubyMine', 'other_name' => 'RubyMine', 'description' => 'Produce high-quality code more efficiently, thanks to first-class support for Ruby and Rails, JavaScript and CoffeeScript, ERB and HAML, CSS, Sass and Less, and more.'],
                    ['name' => 'WebStorm', 'other_name' => 'WebStorm', 'description' => 'WebStorm is an integrated development environment for JavaScript and related technologies. Like other JetBrains IDEs, it makes your development experience more enjoyable, automating routine work and helping you handle complex tasks with ease.'],
                ]
            ],
        ];

        foreach ($brands as $brand) {
            $Brand = Brand::create([
                'asset_subclass_id' => AssetSubclass::where('name', $brand['subclass'])->first()->id,
                'name' => $brand['name']
            ]);

            foreach ($brand['brand_models'] as $brand_model)
            {
                BrandModel::create([
                    'brand_id' => $Brand->id,
                    'name' => $brand_model['name'],
                    'other_name' => $brand_model['other_name'],
                    'description' => $brand_model['description'],
                ]);
            }
        }
    }
}
