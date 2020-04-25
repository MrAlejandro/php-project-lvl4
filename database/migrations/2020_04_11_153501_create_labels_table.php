<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsTable extends Migration
{
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(true)->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('labels');
    }
}
