<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'TaiKhoan';

    public $timestamps = false;

    protected $fillable = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPosition(): string
    {
        $roleMapPos = [
            'admin' => 'Quản trị',
            'doctor' => 'Bác sĩ',
            'nurse' => 'Y tá',
            'receptionist' => 'Lễ tân'
        ];

        return $roleMapPos[$this->role];
    }

    public function dto()
    {
        return [
            "username" => $this->username,
            "full_name" => $this->full_name,
            "dob" => $this->dob,
            "phone" => $this->phone,
            "address" => $this->address,
            "role" => $this->role,
            "position" => $this->getPosition()
        ];
    }

    public function getAuthPassword()
    {
        return $this['MatKhau'];
    }

    public function role(): HasOne
    {
        return $this->hasOne(PhanQuyen::class, 'id');
    }

    public function employee(): HasOne
    {
        return $this->hasOne(PhanQuyen::class, 'id');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'id');
    }
}
