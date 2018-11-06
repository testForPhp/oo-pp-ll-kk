<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('link_id')->index();
            $table->integer('user_id')->index();
            $table->integer('sort_id')->default(0);
            $table->string('summary')->nullable(true);
            $table->integer('end_date');
            $table->tinyInteger('status')->default(0)->index();
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
        Schema::dropIfExists('fee_log');
    }
}
