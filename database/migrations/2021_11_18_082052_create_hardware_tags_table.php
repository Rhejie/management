<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('physical_asset_id')->constrained('physical_assets')->onDelete('cascade');
            $table->foreignId('software_license_id')->constrained('software_licenses')->onDelete('cascade');
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
        Schema::dropIfExists('hardware_tags');
        Schema::enableForeignKeyConstraints();
    }
}
