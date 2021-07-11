<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaxesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function(Blueprint $table){
            $table->id();
            $table->bigInteger('room_id')->unsigned();
            $table->string('type', 20);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10);
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
