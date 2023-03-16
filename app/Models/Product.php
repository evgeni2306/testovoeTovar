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
        'updated_at'
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

}
