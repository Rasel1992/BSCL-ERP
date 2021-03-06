<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('parent_id');
            $table->enum('type', ['Fixed', 'Current', 'Stock']);
            $table->string('category_name');
            $table->string('category_code')->unique()->nullable();
            $table->unique(["parent_id", "category_name"], 'parent-cat');
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
        Schema::dropIfExists('stock_categories');
    }
}
