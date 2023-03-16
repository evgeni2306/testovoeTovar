<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'name',
    ];
    protected $hidden = [
        'getStats',
        'created_at',
        'updated_at'
    ];

    public function getStats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Stat::class);
    }

    static function connectionToProduct(int $productId, array $categories)
    {
        foreach ($categories as $item) {
            ProductCategory::query()->create(['product_id' => $productId, 'category_id' => $item]);
            $category = self::query()->find($item);
            foreach ($category->getStats as $stat){
                StatValue::query()->create(['product_id'=>$productId,'stat_id'=>$stat->id]);
            }
        }
    }
}
