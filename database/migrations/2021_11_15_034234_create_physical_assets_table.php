<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_assets', function (Blueprint $table) {
            $table->id();
            // $table->smallInteger('account_type');//capex = 1,opex = 2
            // $table->foreignId('asset_class_id')->constrained('asset_classes')->onDelete('cascade');
            // $table->foreignId('asset_subclass_id')->constrained('asset_subclasses')->onDelete('cascade');
            // $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('brand_model_id')->constrained('brand_models')->onDelete('cascade');
            $table->foreignId('po_number_id')->constrained('purchase_orders')->onDelete('cascade');
            // $table->string('name');
            // $table->string('description')->nullable();
            $table->foreignId('segment_id')->constrained('segments')->onDelete('cascade');
            $table->boolean('disposal')->default(false);
            // $table->unsignedDecimal('asset_value');
            // $table->unsignedDecimal('accounting_value',8,2);
            // $table->unsignedDecimal('accumulated_depreciation',8,2)->nullable();
            // $table->boolean('isPEZA');
            // $table->integer('lifespan');//months

            // $table->unsignedInteger('quantity');
            $table->nullableMorphs('assetable');

            // $table->string('mother_asset_id');
            // $table->string('mother_asset_code');
            $table->boolean('isActive')->default(true);
            $table->string('sap_code')->nullable();

            // $table->string('availability');
            // $table->unsignedTinyInteger('availability'); //1=available, 2=for re-purpose, 3=for re-assignment, 4=assigned
            // $table->string('serial_number');
            // $table->string('asset_number');//can be sap code
            // $table->boolean('isOPEX');
            // $table->string('account_type');//capex = 0,opex = 1
            // $table->string('sap_code')->nullable();
            // $table->foreignId('mother_asset_code')->constrained('mother_asset')->onDelete('cascade');
            // $table->string('mother_asset_code')->default('DEF_MOTHER_ASSET_CODE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();        
        Schema::dropIfExists('physical_assets');
        Schema::enableForeignKeyConstraints();
    }
}
