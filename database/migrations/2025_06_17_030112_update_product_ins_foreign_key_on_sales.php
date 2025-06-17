<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductInsForeignKeyOnSales extends Migration
{
    public function up()
    {
        // Hapus dulu foreign key lama
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'product_ins_id')) {
                $table->dropForeign(['product_ins_id']);
                $table->foreign('product_ins_id')
                    ->references('id')
                    ->on('product_ins')
                    ->nullOnDelete(); // Biarkan kolom jadi NULL saat product_ins dihapus
            }
        });

        // Tidak ubah foreign key sales_details agar tidak ikut terhapus
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['product_ins_id']);
            $table->foreign('product_ins_id')
                ->references('id')
                ->on('product_ins')
                ->onDelete('cascade'); // Restore default behavior jika perlu
        });
    }
}
