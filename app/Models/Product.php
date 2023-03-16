<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'name',
        'price',
        'amount',
        'description',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'getStats'
    ];

    static function findByCategorie(int $categoryId): Collection
    {
        return Product::query()
            ->join('product_categories', 'product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->select('products.id', 'products.name', 'price', 'amount')
            ->where('category_id', '=', $categoryId)
            ->get();
    }

    static function deleteWithDependencies(int $productId): void
    {
        ProductCategory::query()->where('product_id', '=', $productId)->delete();
        StatValue::query()->where('product_id', '=', $productId)->delete();
        self::query()->find($productId)->delete();
    }

    public function getStats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StatValue::class);
    }

    static function deleteCategoryConnection(int $productId, int $categoryId): void
    {
        $stats = Stat::query()->where('category_id', '=', $categoryId)->get()->all();
        foreach ($stats as $stat) {
            StatValue::query()
                ->where('product_id', '=', $productId)
                ->where('stat_id', '=', $stat->id)
                ->delete();
        }
        ProductCategory::query()
            ->where('product_id', '=', $productId)
            ->where('category_id', '=', $categoryId)
            ->delete();
    }

    static function addCategoryConnection(int $productId, int $categoryId): void
    {
        ProductCategory::query()->create(['product_id' => $productId, 'category_id' => $categoryId]);
        $stats = Stat::query()->where('category_id', '=', $categoryId)->get()->all();
        foreach ($stats as $stat) {
            StatValue::query()->create(['product_id'=>$productId,'stat_id'=>$stat->id]);
        }
    }


}
