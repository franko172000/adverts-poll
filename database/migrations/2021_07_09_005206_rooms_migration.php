<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function(Blueprint $table){
            $table->id();
            $table->bigInteger('hotel_id')->unsigned();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('net_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
