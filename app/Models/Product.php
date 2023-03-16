<?php
declare(strict_types=1);

namespace App\Models;

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

}
