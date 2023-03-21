<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_model_id')->constrained('brand_models')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('po_number');
            $table->dateTime('date_acquired',0);
            $table->dateTime('expiration_date',0);
            $table->boolean('commit')->default(true); // yes-1 or no-0
            // $table->string('asset_number');
            $table->smallInteger('account_type');//capex = 1,opex = 2
            $table->unsignedDecimal('asset_value');
            $table->unsignedDecimal('accounting_value',8,2)->nullable();
            $table->unsignedDecimal('accumulated_depreciation',8,2)->nullable();
            $table->boolean('isPEZA');
            $table->integer('lifespan');//months
            
            $table->unsignedInteger('quantity');
            $table->string('serial_number');
            $table->dateTime('warranty_date',0);
            $table->string('warranty_description');
            $table->string('sap_code')->nullable();
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
        Schema::dropIfExists('purchase_orders');
        Schema::enableForeignKeyConstraints();
    }
}
