<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];

    public function getStatusAttribute($value): string
    {
        return $value == 'active' ? 'فعال' : 'غیر فعال';
    }

    public function getCreatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, "yyyy/MM/dd HH:mm:ss");
    }

    public function getUpdatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, "yyyy/MM/dd HH:mm:ss");
    }
}
