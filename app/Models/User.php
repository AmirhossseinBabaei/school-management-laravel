<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar_src',
        'avatar_type',
        'otp_expire_at',
        'phone',
        'email',
        'password_hash',
        'status',
        'school_id',
        'role_id',
        'national_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
        'otp_code'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
    /**
     * Make Laravel Auth use custom password column.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

//    public function getUpdatedAtAttribute($value): string
//    {
//        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss') ?? '';
//    }
//
//    public function getCreatedAtAttribute($value): string
//    {
//        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss') ?? '';
//    }

    public function hasRole(string $role):bool
    {
        if ('admin' === $role) {
            return Auth::user()->role_id == 1;
        }
        else if ('owner' === $role){
            return Auth::user()->role_id == 2;
        }
        else {
            return false;
        }
    }
}
