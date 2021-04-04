<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->enum('assign_to', ['user', 'department']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->foreign('dept_id')->on('departments')->references('id')->onDelete('cascade');
            $table->string('voucher_no')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->enum('location', ['hq', 'gs1', 'gs2']);
            $table->date('purchase_date');
            $table->date('assign_date');
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
        Schema::dropIfExists('inventories');
    }
}
