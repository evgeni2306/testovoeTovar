<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTable extends Migration
{
    const TABLE_NAME = 'stats';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('name', 255)->nullable(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
