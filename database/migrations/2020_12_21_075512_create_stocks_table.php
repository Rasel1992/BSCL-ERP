<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('qty');
            $table->enum('location', ['hq', 'gs1', 'gs2']);
            $table->date('stock_date');
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
        Schema::dropIfExists('stocks');
    }
}
