<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsForeignKeys extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the existing foreign keys
            $table->dropForeign(['category_id']);
            $table->dropForeign(['supplier_id']);


            // Add new foreign keys with `set null` behavior
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the modified foreign keys
            $table->dropForeign(['category_id']);
            $table->dropForeign(['supplier_id']);

            // Restore the previous foreign key relationships, optionally using `cascade` or no action
            // You can choose to restore to `onDelete('cascade')` or other behavior depending on the original setup
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
          
        });
    }
}
