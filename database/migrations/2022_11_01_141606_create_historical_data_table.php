<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historical_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('price');
            $table->uuid('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('historical_data');
    }
};
