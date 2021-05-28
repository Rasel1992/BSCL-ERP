<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sl_number');
            $table->unsignedBigInteger('requisition_to')->nullable();
            $table->unsignedBigInteger('verified_to')->nullable();
            $table->unsignedBigInteger('approved_to')->nullable();
            $table->unsignedBigInteger('received_to')->nullable();
            $table->unsignedBigInteger('disbursed_to')->nullable();
            $table->unsignedBigInteger('requisition_by')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->unsignedBigInteger('disbursed_by')->nullable();
            $table->string('actual_user')->nullable();
            $table->date('requisition_date');
            $table->enum('verified_status', ['Pending', 'Accept', 'Reject'])->default('Pending');
            $table->enum('approved_status', ['Pending', 'Accept', 'Reject'])->default('Pending');
            $table->enum('received_status', ['Pending', 'Accept', 'Reject'])->default('Pending');
            $table->enum('disbursed_status', ['Pending', 'Accept', 'Reject'])->default('Pending');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
