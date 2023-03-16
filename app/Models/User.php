<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function setPasswordAttribute($password):void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setAuthKeyAttribute($authKey):void
    {
        $this->attributes['authKey'] = hash("sha256",$authKey . self::KEY);
    }

    static function getIdByKey($authKey):int
    {
        return self::query()->where('authKey', $authKey)->select('id')->get()[0]->id;
    }
}
