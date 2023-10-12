<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LichKham extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'lichkham';

    public $timestamps = false;

    public function nguoiTao(): BelongsTo
    {
        return $this->belongsTo(NhanVien::class, 'NguoiTao');
    }

    public function bacSi(): BelongsTo
    {
        return $this->belongsTo(NhanVien::class, 'BacSi');
    }
}
