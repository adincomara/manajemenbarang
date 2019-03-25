<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('slug');
            // $table->text('description');
            $table->string('spek');
            $table->string('status_barang');
            $table->string('gambar');
            $table->float('harga');
            // $table->integer('views')->default(0)->unsigned();
            $table->integer('stock')->default(0)->unsigned();
            $table->enum('status', ['DIJUAL', 'TIDAK DIJUAL']);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
