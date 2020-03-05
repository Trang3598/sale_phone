<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_name',25);
            $table->string('customer_phone',25);
            $table->string('customer_email',30);
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade')->onUpdate('no action');
            $table->bigInteger('deliverer_id')->unsigned();
            $table->foreign('deliverer_id')->references('id')->on('deliverer')->onDelete('cascade')->onUpdate('no action');
            $table->integer('total_price');
            $table->string('delivery_address',190);
            $table->string('note',190)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
