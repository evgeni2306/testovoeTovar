<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    const KEY = "C5KFL";

    protected $fillable = [
        'name',
        'surname',
        'login',
        'password',
        'key',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setKeyAttribute($key)
    {
        $this->attributes['key'] = Hash::make($key . self::KEY);
    }

    static function getIdByKey($key)
    {
        return self::query()->where('key', $key)->select('id')->get()[0]->id;
    }
}
