<?php

use App\Models\Sales;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailsTable extends Migration
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
            $table->foreignId('sales_id')
                ->nullable()
                ->constrained('sales')
                ->nullOnDelete(); // key ke tabel sales
            $table->dateTime('date_order')->nullable();
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->nullOnDelete('set null'); // Foreign key ke tabel discounts, nullable
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('total', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('change', 15, 2)->nullable();
            $table->string('transaction_number');
            $table->string('invoice_number');
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
