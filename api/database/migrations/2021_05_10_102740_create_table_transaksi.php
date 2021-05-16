<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('no_invoice')->unique();
            $table->integer('total_barang')->unsigned();
            $table->enum('status_transaksi', ['PROSES', "ACC", "TOLAK"])->default('PROSES');
            $table->integer('id_user')->unsigned();

            $table->index(['id_user']);

            $table->timestamps();

            // foreign key
            $table->foreign('id_user')
                ->references('id')->on('user')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
