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
            $table->string('name_phone', 255);
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->bigInteger('quantity');
            $table->string('detail', 255)->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('size',255)->nullable();
            $table->string('memory', 255)->nullable();
            $table->float('weight')->nullable();
            $table->string('cpu_speed', 255)->nullable();
            $table->string('ram', 255)->nullable();
            $table->string('os', 255)->nullable();
            $table->string('camera_primary', 255)->nullable();
            $table->string('battery', 255)->nullable();
            $table->string('warranty', 255)->nullable();
            $table->string('bluetooth', 255)->nullable();
            $table->string('wlan', 255)->nullable();
            $table->bigInteger('promotion_price')->nullable();
            $table->dateTime('start_promotion', 6)->nullable();
            $table->dateTime('end_promotion', 6)->nullable();
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
