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
            $table->string('name');
            $table->longText('description');
            $table->decimal('price', 8, 2)->default(1);
            $table->integer('quantity');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->boolean('isOnSale')->default(0);
            $table->boolean('isOverSale')->default(0);
            $table->boolean('isPromotion')->default(0);
            $table->decimal('promoPrice', 8, 2)->default(0);
            $table->text('author')->nullable();
            $table->text('publisher')->nullable();
            $table->text('isbn')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('pages')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('product');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
