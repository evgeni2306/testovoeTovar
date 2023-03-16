<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    const KEY = "C5KFL";

    protected $fillable = [
        'name',
        'surname',
        'login',
        'password',
        'authKey',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setAuthKeyAttribute($authKey)
    {
        $this->attributes['authKey'] = Hash::make($authKey . self::KEY);
    }

    static function getIdByKey($authKey)
    {
        return self::query()->where('authKey', $authKey)->select('id')->get()[0]->id;
    }
}
