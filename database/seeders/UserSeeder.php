<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = User::create([
            'name' => 'Main Admin',
            'email' => 'jez@chimesconsulting.com',
            'password' => Hash::make('@.--cams'),
            'status' => 1
        ]);

        $super_admin->assignRole('Super Admin');
    }
}
