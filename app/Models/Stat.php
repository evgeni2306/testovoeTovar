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

    static function deleteWithDependencies(int $statId): void
    {
        StatValue::query()->where('stat_id', '=', $statId)->delete();
        self::query()->find($statId)->delete();
    }

    static function updateProductStats(Stat $stat): void
    {
        $products = Product::query()
            ->join('product_categories', 'product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->select('products.id')
            ->where('category_id', '=', $stat->category_id)
            ->get()->all();
        foreach ($products as $product) {
            StatValue::query()->create(['product_id' => $product->id, 'stat_id' => $stat->id]);
        }
    }
}
