<?php

use App\Models\Category;
use App\Models\Pic;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ins', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class, 'product_id')
                ->nullable()
                ->constrained((new Product())->getTable())
                ->nullOnDelete();

            $table->date('date'); // tanggal permohonan masuk
            $table->string('requester_name')->comment('Nama pemohon'); // ⬅️ Tambahan
            $table->string('recipient')->nullable()->comment('Penerima saat disetujui'); // nullable, karena nanti diisi pas disetujui

            $table->integer('qty');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu'); // ⬅️ Gunakan enum agar konsisten
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
        Schema::dropIfExists('product_ins');
    }
}
