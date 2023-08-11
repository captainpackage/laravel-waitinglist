<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitinglistTable extends Migration
{
    public function up()
    {
        Schema::create('waitinglist', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->integer('position');
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waitinglist');
    }
}