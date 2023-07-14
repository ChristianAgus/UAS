<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_code')->unique();
            $table->string('device_name');
            $table->string('device_price');
            $table->text('device_description')->nullable();
            $table->enum('device_status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('device_master');
    }
}
