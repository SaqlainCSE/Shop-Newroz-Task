<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimilarProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similar_products', function (Blueprint $table) {
            $table->increments('similar_product_id');
            $table->integer('product_id');
            $table->text('product_name')->unique();
            $table->longText('product_description');
            $table->float('product_price');
            $table->string('product_image');
            $table->string('product_weight');
            $table->string('product_quantity');
            $table->integer('category_id');
            $table->integer('manufacture_id');
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
        Schema::dropIfExists('similar_products');
    }
}