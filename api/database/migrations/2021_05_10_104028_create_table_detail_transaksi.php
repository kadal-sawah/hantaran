<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetailTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_transaksi')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->integer('qty');
            $table->integer('harga');

            // index
            $table->index(['id_transaksi', 'id_produk']);

            // foreign key
            $table->foreign('id_transaksi')
                ->references('id')->on('transaksi')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_produk')
                ->references('id')->on('produk')
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
        Schema::dropIfExists('detail_transaksi');
    }
}
