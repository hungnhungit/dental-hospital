<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NhanVien extends Model
{
    use HasFactory;

    public $table = 'NhanVien';

    public $timestamps = false;

    protected $fillable = [];

    public function taiKhoan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'TaiKhoanId');
    }

    public function chucVu(): BelongsTo
    {
        return $this->belongsTo(ChucVu::class, 'ChucVuId');
    }
}
