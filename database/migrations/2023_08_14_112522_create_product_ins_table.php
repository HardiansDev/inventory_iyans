<?php

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
            $table->integer('product_id');
            $table->dateTime('date');
            $table->string('recipient')->comment("penerima");
            $table->integer('pic_id');
            $table->integer('supplier_id');
            $table->integer('category_id');
            $table->string('status'); //verifikasi pic
            $table->string('qty');
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
