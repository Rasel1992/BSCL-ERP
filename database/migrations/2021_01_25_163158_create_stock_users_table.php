<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->enum('assign_to', ['user', 'department']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->string('qty');
            $table->date('assign_date');
            $table->text('remark')->nullable();
            $table->string('apply_no')->nullable();
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
        Schema::dropIfExists('stock_users');
    }
}
