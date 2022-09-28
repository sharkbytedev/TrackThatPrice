<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid("id");
            $table->string("product_name");
            $table->string("product_url");
            $table->string("image_url")->nullable();
            $table->integer("update_interval");
            $table->integer("last_queried")->default(0);
            $table->string("store");
            $table->smallInteger("last_status_code")->nullable();
            $table->boolean("valid")->default(true);
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
        Schema::dropIfExists('products');
    }
};
