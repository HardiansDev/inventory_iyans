<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('code')->unique();
            $table->string('photo')->nullable();

            // Foreign keys with SET NULL
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('pic_id')->nullable()->constrained('pics')->onDelete('set null'); // explicitly reference the 'pics' table

            $table->decimal('price', 10, 2);
            // $table->integer('qty');
            $table->string('stock');
            $table->string('status')->default('menunggu');
            // $table->string('purchase');
            // $table->string('billnum');
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['pic_id']);
        });
        Schema::dropIfExists('products');
    }
}
