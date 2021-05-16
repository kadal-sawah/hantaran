<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetailGambar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_gambar', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_produk')->unsigned();
            $table->string('gambar');

            // index
            $table->index(['id_produk']);

            // foreign key
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
        Schema::dropIfExists('detail_gambar');
    }
}
