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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores', 'id_toko')->onDelete('cascade');
            $table->foreignId('sale_id')->nullable()->constrained('sales', 'id_penjualan')->onDelete('set null');
            $table->integer('points')->default(0);
            $table->text('description')->nullable();
            $table->string('type')->default('earned'); // 'earned', 'redeemed', etc.
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
        Schema::dropIfExists('points');
    }
};
