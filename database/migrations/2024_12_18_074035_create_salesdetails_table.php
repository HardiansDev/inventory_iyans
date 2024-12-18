<?php

use App\Models\Sales;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sales::class, 'sales_id')
                ->constrained((new Sales())->getTable())
                ->onDelete('cascade');
            $table->dateTime('date_order');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->decimal('amount', 15, 2);    // Nilai untuk jumlah item
            $table->decimal('total', 15, 2);     // Total transaksi
            $table->decimal('subtotal', 15, 2);  // Subtotal transaksi
            $table->decimal('change', 15, 2);    // Kembalian
            $table->string('transaction_number', 50)->unique(); // Nomor transaksi
            $table->string('invoice_number', 50)->unique();    // Nomor faktur
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
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
        Schema::dropIfExists('salesdetails');
    }
}
