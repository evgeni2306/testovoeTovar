<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    const TABLE_NAME = "product_categories";

    public function up():void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('category_id')->constrained('categories');
            $table->unique(['product_id','category_id']);
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
