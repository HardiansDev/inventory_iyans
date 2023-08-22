<?php

use App\Models\Category;
use App\Models\Pic;
use App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function App\Models\Pic;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Supplier::class, 'supplier_id')
                ->constrained((new Supplier())->getTable())
                ->onDelete('cascade');
            $table->foreignIdFor(Pic::class, 'pic_id')
                ->constrained((new Pic())->getTable())
                ->onDelete('cascade');
            $table->foreignIdFor(Category::class, 'category_id')
                ->constrained((new Category())->getTable())
                ->onDelete('cascade');

            $table->string('name');
            $table->string('code');
            $table->string('photo');
            $table->integer('price');
            $table->integer('qty');
            $table->string('stock');
            $table->string('quality'); //bagus, cacad
            $table->string('purchase');
            $table->string('billnum');

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
        Schema::dropIfExists('products');
    }
}
