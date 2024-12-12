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
                ->constrained((new Product())->getTable())
                ->onDelete('cascade');
            $table->foreignIdFor(Supplier::class, 'supplier_id')
                ->constrained((new Supplier())->getTable())
                ->onDelete('cascade');
            $table->foreignIdFor(Category::class, 'category_id')
                ->constrained((new Category())->getTable())
                ->onDelete('cascade');

            $table->dateTime('date');
            $table->string('recipient')->comment("penerima");
            $table->string('qty');
            $table->string('status')->default('menunggu');
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
