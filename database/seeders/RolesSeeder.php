<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            (object)[
                'name' => 'Admin',
                'permissions' => [
                    'Asset_User-Bulk_upload',
                    'Asset_User-Add_User',
                    'Asset_User-Update_User',            
                    'Asset_User-Deactivate_User',
                    'Asset_User-Cost_Center_Tagging',

                    'Inventory_Module-Add_OPEX-Software_or_License',
                    'Inventory_Module-Update_OPEX-Software_or_License',
                    'Inventory_Module-Deactiviate_OPEX-Software_or_License',
                    'Inventory_Module-Add_OPEX-Physical_Asset',
                    'Inventory_Module-Update_OPEX-Physical_Asset',
                    'Inventory_Module-Deactivate_OPEX-Physical_Asset',

                    'Transaction_Module-Approver_Module',
                    'Transaction_Module-Asset_Requisition',
                    'Transaction_Module-Asset_Transfer',
                    'Transaction_Module-Asset_Renewal',
                    'Transaction_Module-Asset_Disposal',
                    'Transaction_Module-Asset_Pull-out',
                ],
            ],
        ];

        Role::create(['name' => 'Super Admin']);
        
        foreach ($roles as $role) {
            $created_role = Role::create(['name' => $role->name]);
            foreach ($role->permissions as $permission) {
                $created_role->givePermissionTo($permission);
            }
        }
    }
}
