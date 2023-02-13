<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreign('vendor_id')->references('id')->on('vendor');
            $table->string('name');
            $table->longText('description');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->longText('pic');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('brand')->references('id')->on('brand');
            $table->boolean('isOnSale');
            $table->boolean('isOverSale');

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
        Schema::dropIfExists('product');
    }
};
