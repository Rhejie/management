<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('proponentable');
            $table->morphs('assetable');
            $table->smallInteger('transaction_type_id');
            $table->string('attachment_url');
            $table->json('details');
            $table->string('ticket_number')->unique();
            $table->string('ticket_status');
            $table->boolean('isAcknowledged')->default(false);
            $table->timestamp('date_acknowledged',0)->nullable();
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
        Schema::dropIfExists('transactions');
        Schema::enableForeignKeyConstraints();
    }
}
