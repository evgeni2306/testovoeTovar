<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'category_id',
        'name',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'category_id'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function deleteWithDependencies(int $statId): void
    {
        StatValue::query()->where('stat_id', '=', $statId)->delete();
        self::query()->find($statId)->delete();
    }
}
