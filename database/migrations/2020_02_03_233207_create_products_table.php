<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_cate')->unsigned();
            $table->foreign('id_cate')->references('id')->on('categories')->onDelete('restrict')->onUpdate('no action');
            $table->string('name_phone', 50);
            $table->string('title', 190)->nullable();
            $table->string('description', 190)->nullable();
            $table->bigInteger('quantity');
            $table->string('detail', 190)->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('size',50)->nullable();
            $table->string('memory', 50)->nullable();
            $table->float('weight')->nullable();
            $table->string('cpu_speed', 50)->nullable();
            $table->string('ram', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('camera_primary', 50)->nullable();
            $table->string('battery', 50)->nullable();
            $table->string('warranty', 50)->nullable();
            $table->string('bluetooth', 50)->nullable();
            $table->string('wlan', 50)->nullable();
            $table->bigInteger('promotion_price')->nullable();
            $table->dateTime('start_promotion')->nullable();
            $table->dateTime('end_promotion')->nullable();
            $table->tinyInteger('sale_phone')->nullable();
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
        Schema::dropIfExists('products');
    }
}
