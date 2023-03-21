<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetSubclassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_subclasses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_class_id')->constrained('asset_classes')->onDelete('cascade');
            $table->string('name');
            $table->string('extension')->nullable();
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
        Schema::dropIfExists('asset_subclasses');
        Schema::enableForeignKeyConstraints();
    }
}
