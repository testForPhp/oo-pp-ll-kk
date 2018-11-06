<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rank')->default(0);
            $table->integer('rank_num')->default(0);
            $table->integer('color')->default(0);
            $table->integer('color_num')->default(0);
            $table->integer('img')->default(0);
            $table->integer('img_num')->default(0);
            $table->integer('recommend')->default(0);
            $table->integer('recommend_num')->default(0);
            $table->integer('recommend_id')->default(0);
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
        Schema::dropIfExists('fee');
    }
}
