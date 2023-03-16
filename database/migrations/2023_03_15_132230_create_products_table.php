<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    const TABLE_NAME = "products";

    public function up():void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users');
            $table->string('name', 255)->nullable(false);
            $table->decimal('price')->nullable(false);
            $table->integer('amount')->nullable(false)->unsigned();
            $table->string('description')->nullable(false);
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
