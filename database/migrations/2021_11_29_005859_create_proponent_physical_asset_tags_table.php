<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProponentPhysicalAssetTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proponent_physical_asset_tags', function (Blueprint $table) {
            $table->id();
            $table->morphs('proponentable');
            $table->foreignId('physical_asset_id')->constrained('physical_assets')->onDelete('cascade');
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
        Schema::dropIfExists('proponent_physical_asset_tags');
        Schema::enableForeignKeyConstraints();
    }
}
