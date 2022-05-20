<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoundandlostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foundandlost', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('LOST'); //LOST, RECOVERED
            $table->string('photo');
            $table->string('description');
            $table->string('where');
            $table->date('datecreated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foundandlost');
    }
}
