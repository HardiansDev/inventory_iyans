<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPenjualanToProductInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_ins', function (Blueprint $table) {
            $table->enum('status_penjualan', [
                'belum dijual',
                'sedang dijual',
                'stok tinggal dikit',
                'stok habis terjual',
            ])->default('belum dijual')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_ins', function (Blueprint $table) {
            $table->dropColumn('status_penjualan');
        });
    }
}
