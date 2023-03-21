<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::firstOrCreate([
            'name' => 'Finance',
            'sap_code' => Str::random(8),
        ]);

        Department::firstOrCreate([
            'name' => 'IT',
            'sap_code' => Str::random(8),
        ]);

        Department::firstOrCreate([
            'name' => 'Production',
            'sap_code' => Str::random(8),
        ]);

        Department::firstOrCreate([
            'name' => 'Human Resource',
            'sap_code' => Str::random(8),
        ]);
    }
}
