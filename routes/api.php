<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\UserController@requestToken');
Route::post('reset-password-request', 'Api\PasswordResetRequestController@sendPasswordResetEmail');
Route::post('change-password', 'Api\ChangePasswordController@passwordResetProcess');
Route::post('token-check', 'Api\UserController@checkToken');

Route::get('error', function () {
    return [
        'error' => true,
        'message' => 'You are unauthorized'
    ];
})->name('error');


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('logout', 'Api\UserController@logout');

    Route::get('permission', 'Api\PermissionController@userPermission');
    // Route::post('assets/all?with-subclasses={isWithSubclass}', 'Api\AssetClassController@all');
});

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['role:Admin|Super Admin']], function() {
        Route::post('register', 'Api\UserController@register');

        Route::prefix('users')->group(function () {
            Route::get('all', 'Api\UserController@all');
            Route::patch('status-update', 'Api\UserController@statusUpdate');
            Route::patch('profile-update', 'Api\UserController@profileUpdate');
            Route::patch('assign-role', 'Api\RoleController@assignRole');
            Route::patch('revoke-role', 'Api\RoleController@revokeRole');
        });

        Route::prefix('roles')->group(function () {
            Route::get('all', 'Api\RoleController@index');
            Route::post('create', 'Api\RoleController@createWithPermissions');
            Route::get('role-with-permission/{role:name}', 'Api\RoleController@roleWithPermissions');
            Route::patch('edit', 'Api\RoleController@updateWithPermissions');
        });

        Route::prefix('permissions')->group(function(){
            Route::get('all', 'Api\PermissionController@all');
            Route::post('create', 'Api\PermissionController@create');
        });

        Route::prefix('companies')->group(function () {
            Route::get('all', 'Api\CompanyController@index');
            Route::get('company-with-sites/{company:slug}', 'Api\CompanyController@companySites');
            Route::get('company-sites/{company:slug}', 'Api\SiteController@companySites');
        });

        Route::prefix('sites')->group(function () {
            Route::get('all', 'Api\SiteController@all');
            Route::get('site-campaigns/{site}', 'Api\CampaignController@siteCampaigns');
            Route::post('search', 'Api\SiteController@search');
            Route::post('create', 'Api\SiteController@create');
            Route::patch('edit', 'Api\SiteController@update');
            Route::delete('delete', 'Api\SiteController@delete');
        });

        Route::prefix('cost-centers')->group(function () {
            Route::get('all', 'Api\CostCenterController@all');
            Route::post('create', 'Api\CostCenterController@create');
            Route::patch('edit', 'Api\CostCenterController@update');
            Route::delete('delete', 'Api\CostCenterController@delete');
        });

        Route::prefix('campaigns')->group(function () {
            Route::get('all', 'Api\CampaignController@all');
            Route::post('search', 'Api\CampaignController@search');
            Route::post('create', 'Api\CampaignController@create');
            Route::patch('edit', 'Api\CampaignController@update');
            Route::delete('delete', 'Api\CampaignController@delete');
        });

        Route::prefix('employees')->group(function () {
            Route::get('all', 'Api\EmployeeController@all');
            Route::get('details', 'Api\EmployeeController@employeeList');
            Route::post('search', 'Api\EmployeeController@search');
            Route::post('create', 'Api\EmployeeController@create');
            Route::post('bulk-upload', 'Api\EmployeeController@bulkUploads');
            Route::patch('edit', 'Api\EmployeeController@update');
            Route::delete('delete', 'Api\EmployeeController@delete');
        });

        Route::prefix('assets')->group(function () {
            Route::get('all', 'Api\AssetClassController@index');
            Route::get('type/{asset_type_id}', 'Api\AssetClassController@searchByType');
            Route::post('create', 'Api\AssetClassController@create');
            Route::patch('edit', 'Api\AssetClassController@update');
            Route::delete('delete', 'Api\AssetClassController@delete');

            Route::prefix('subclasses')->group(function () {
                Route::get('all', 'Api\AssetSubclassController@index');
                Route::get('view/{asset_class_id}', 'Api\AssetSubclassController@view');
                Route::post('create', 'Api\AssetSubclassController@create');
                Route::patch('edit', 'Api\AssetSubclassController@update');
                Route::delete('delete', 'Api\AssetSubclassController@delete');
            });
        });

        Route::prefix('brands')->group(function () {
            Route::get('all', 'Api\BrandController@index');
            Route::get('view/{asset_subclass_id}', 'Api\BrandController@view');
            Route::post('create', 'Api\BrandController@create');
            Route::patch('edit', 'Api\BrandController@update');
            Route::delete('delete', 'Api\BrandController@delete');

            Route::prefix('models')->group(function () {
                Route::get('all', 'Api\BrandModelController@index');
                Route::get('software-inventory', 'Api\BrandModelController@softwareInventory');
                Route::get('physical-asset-inventory', 'Api\BrandModelController@physicalAssetInventory');
                Route::get('asset-summary/{brand_model_id}', 'Api\BrandModelController@brandModelSummary');
                Route::get('view/{brand_id}', 'Api\BrandModelController@view');
                Route::post('search', 'Api\BrandModelController@search');
                Route::post('search-all', 'Api\BrandModelController@searchAsset');
                Route::post('create', 'Api\BrandModelController@create');
                Route::patch('edit', 'Api\BrandModelController@update');
                Route::delete('delete', 'Api\BrandModelController@delete');
            });
        });

        Route::prefix('purchase-orders')->group(function () {
            Route::get('all', 'Api\PurchaseOrderController@all');
            Route::post('create', 'Api\PurchaseOrderController@create');
            Route::post('edit', 'Api\PurchaseOrderController@updateSummary');
            Route::get('view/{po_number}', 'Api\PurchaseOrderController@view');
        });

        Route::prefix('proponents')->group(function (){
            Route::get('types', 'Api\ProponentController@types');
            // Route::get('employee-ranks', 'Api\ProponentController@ranks');
            // Route::get('all', 'Api\ProponentController@index');
            // Route::get('employees', 'Api\ProponentController@employees');
            // Route::get('campaigns', 'Api\ProponentController@campaigns');
            // Route::get('sites', 'Api\ProponentController@sites');
            // Route::get('hardwares', 'Api\ProponentController@hardwares');
            
            // Route::post('bulk-upload', 'Api\ProponentController@bulkUploads');
            // Route::post('create', 'Api\ProponentController@create');
            // Route::patch('edit', 'Api\ProponentController@update');
            // Route::delete('delete', 'Api\ProponentController@delete');
        });

        Route::prefix('software-assets')->group(function () {
            Route::get('all', 'Api\SoftwareLicenseController@all');
            Route::get('view/{id}', 'Api\SoftwareLicenseController@view');
            Route::post('create', 'Api\SoftwareLicenseController@create');
            Route::patch('edit', 'Api\SoftwareLicenseController@update');
        });

        Route::prefix('physical-assets')->group(function () {
            Route::get('all', 'Api\PhysicalAssetController@all');
        });

        Route::prefix('inventory')->group(function () {
            Route::get('all', 'Api\InventoryController@index');
            Route::get('view/{id}', 'Api\InventoryController@view');
            Route::prefix('allocation')->group(function () {
                Route::get('all', 'Api\InventoryQuantityAllocationController@index');
                Route::get('get/{asset_id}', 'Api\InventoryQuantityAllocationController@get');
                Route::post('save', 'Api\InventoryQuantityAllocationController@save');
                
            });
        });

        Route::prefix('segments')->group(function () {
            Route::get('all', 'Api\SegmentController@index');
            Route::post('create', 'Api\SegmentController@create');
            Route::patch('edit', 'Api\SegmentController@update');
            Route::delete('delete', 'Api\SegmentController@delete');
        });

    });
});

Route::prefix('user')->group(function () {
    Route::group(['middleware' => ['role:Regular']], function() {
        Route::get('users', 'Api\UserController@all');
    });
});
