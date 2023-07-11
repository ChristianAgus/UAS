<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_produk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_device_id');
            $table->string('nama_device');
            $table->string('price');
            $table->float('discount');
            $table->integer('quantity');
            $table->string('total');
            $table->string('file');
            $table->timestamps();

            $table->foreign('master_device_id')->references('id')->on('device_master')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_produk');
    }
}
