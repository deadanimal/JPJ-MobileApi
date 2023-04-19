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
        Schema::create('ref', function (Blueprint $table) {
            $table->id();
            $table->integer('kod')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('value')->nullable();
            $table->string('value2')->nullable();
            $table->string('keterangan_apps')->nullable();
            $table->integer('jenis')->nullable();
            $table->integer('jenis2')->nullable();
            $table->integer('susunan')->nullable();
            $table->string('keterangan2')->nullable();
            $table->string('kod2')->nullable();
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
        Schema::dropIfExists('ref');
    }
};
