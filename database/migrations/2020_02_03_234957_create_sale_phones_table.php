<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_phones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('phone_id')->unsigned()->nullable();
            $table->integer('quantity');
            $table->foreign('phone_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('no action');
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
        Schema::dropIfExists('sale_phones');
    }
}
