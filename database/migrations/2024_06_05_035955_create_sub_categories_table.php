<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('subcategory_name');
            $table->string('subcategory_slug')->unique();
            $table->boolean('is_child_of')->default(false);
            $table->integer('ordering')->default(0);
            $table->string('subcategory_image')->nullable();
            $table->decimal('subcategory_price', 8, 2)->nullable(); // For price
            $table->text('subcategory_desc')->nullable(); // For description
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}