<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_user', function(Blueprint $table) {
            $table->integer('threshold')->nullable();
            $table->string('type', 10)->nullable();
            $table->boolean('enabled');
            $table->timestamp('compare_time')->nullable();
        });
    }

    public function down()
    {
        Schema::table('product_user', function(Blueprint $table) {

            $table->dropColumn('threshold');
            $table->dropColumn('type');
            $table->dropColumn('enabled');
            $table->dropColumn('compare_time');
        });
    }
};
