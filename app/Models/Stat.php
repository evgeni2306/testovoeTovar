<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
    ];

    static function createCategoriesStats(int $catId, array $stats):void
    {
        foreach ($stats as $item) {
            self::query()->create(['category_id' => $catId, 'name' => $item]);
        }
    }
}
