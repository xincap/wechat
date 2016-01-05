<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginWechatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugin_wechat', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('wechat_id');
            $table->unsignedBigInteger('plugin_id');
            
            $table->foreign('wechat_id')->references('id')->on('wechat')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('plugin_id')->references('id')->on('plugin')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plugin_wechat');
    }
}
