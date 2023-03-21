<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // $permissions = [
        //     'permission_create',
        //     'permission_edit',
        //     'permission_deactivate',            
        //     'permission_access',

        //     'role_create',
        //     'role_edit',
        //     'role_deactivate',
        //     'role_access',

        //     'account_create',
        //     'account_edit',
        //     'account_deactivate',
        //     'account_access',
            
        //     'employee_create',
        //     'employee_edit',
        //     'employee_deactivate',
        //     'employee_access',

        //     'campaign_create',
        //     'campaign_edit',
        //     'campaign_deactivate',
        //     'campaign_access',

        //     'cost_center_create',
        //     'cost_center_edit',
        //     'cost_center_deactivate',
        //     'cost_center_access',

        //     'asset_class_create',
        //     'asset_class_edit',
        //     'asset_class_deactivate',
        //     'asset_class_access',

        //     'asset_assignment',
        //     'asset_transfer',
        //     'asset_dispose',
        //     'employee_accountability_access',
        //     'campaign_accountability_access'
        // ];

        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
