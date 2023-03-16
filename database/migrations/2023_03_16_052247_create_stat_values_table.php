<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatValuesTable extends Migration
{
    const TABLE_NAME = "stat_values";

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('stat_id')->constrained('stats');
            $table->string('value', 255)->nullable(true);
            $table->unique(['product_id','stat_id']);
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
