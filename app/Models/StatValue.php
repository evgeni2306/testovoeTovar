<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'stat_id',
        'value'
    ];
}
