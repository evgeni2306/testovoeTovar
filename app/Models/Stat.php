<?php
declare(strict_types=1);

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
    protected $hidden = [
        'created_at',
        'updated_at',
        'category_id'
    ];

    static function createCategoriesStats(int $catId, array $stats): void
    {
        foreach ($stats as $item) {
            self::query()->create(['category_id' => $catId, 'name' => $item]);
        }
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
