<?php

namespace Database\Seeders;

use App\Models\SoftwareLicense;
use App\Models\Brand;
use App\Models\AssetClass;
use App\Models\AssetSubclass;
use App\Models\Site;
use app\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class SoftwareLicensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maxRelationship = config('constants.MAX_RELATIONSHIPS');
        $maxLicenses = 50;

        Schema::disableForeignKeyConstraints();

        SoftwareLicense::factory($maxLicenses)->create();

        Schema::enableForeignKeyConstraints();

    }
}
