<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_registers', function (Blueprint $table) {
            $table->id();
            $table->string('bill_date');
            $table->string('shop_info');
            $table->string('invoice_number');
            $table->string('invoice_date');
            $table->string('item_name');
            $table->string('subject');
            $table->string('quantity');
            $table->string('cost');
            $table->string('location');
            $table->enum('assign_to', ['person', 'department', 'others']);
            $table->string('qr_code');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('bill_registers');
    }
}
