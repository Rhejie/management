<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('employee_number');
            $table->string('email')->unique();
            $table->string('cost_center_code');
            $table->string('department_code');
            $table->string('company_code');
            $table->string('site_code');
            $table->smallInteger('status')->default(1);
            // $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->onDelete('cascade');
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
        Schema::dropIfExists('employees');
        Schema::enableForeignKeyConstraints();
    }
}
