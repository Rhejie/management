<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProponentSoftwareTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proponent_software_tags', function (Blueprint $table) {
            $table->id();
            $table->morphs('proponentable');
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
        Schema::dropIfExists('proponent_software_tags');
        Schema::enableForeignKeyConstraints();
    }
}
