<?php

use App\Models\Pic;
use App\Models\Product;
use App\Models\ProductIn;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'product_id')
                ->constrained((new Product())->getTable())
                ->onDelete('cascade');


            $table->foreignIdFor(ProductIn::class, 'product_ins_id')
                ->constrained((new ProductIn())->getTable())
                ->onDelete('cascade');

            $table->date('dateout');
            $table->string('nameout');
            $table->string('status'); //verifikasi pic
            $table->integer('qty');
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
        Schema::dropIfExists('product_outs');
    }
}
