<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nama_produk', 255);
            $table->integer('harga');
            $table->integer('stok');
            $table->string('cover', 255);
            $table->text('deskripsi');

            $table->integer('id_jenis')->unsigned();
            // 1 : Aktif
            // 2 : Non Aktif
            $table->enum('is_aktif', ['1', '2'])->default('1');

            // index
            $table->index(['id_jenis']);

            // foreign key
            $table->foreign('id_jenis')
                ->references('id')->on('jenis_hantaran')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('produk');
    }
}
