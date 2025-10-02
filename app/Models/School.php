<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'description',
        'phone',
        'address',
        'email',
        'latitude',
        'longitude',
        'status',
        'uuid'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function getStatusAttribute($value)
    {
        if ($value == 'active') {
            return 'فعال';
        } else if ($value == 'inactive') {
            return 'غیر فعال';
        } else if ($value == 'request') {
            return 'منتظر';
        } else {
            return $value;
        }
    }
}
