<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('jumlah');
            $table->decimal('harga_jual', 10, 2);
            $table->date('tanggal_penjualan');
            $table->string('bukti_penjualan')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('store_id')->references('id_toko')->on('stores')->onDelete('cascade');
            $table->foreign('product_id')->references('id_produk')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
