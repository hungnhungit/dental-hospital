<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoaDon extends Model
{
    use HasFactory;

    public $table = 'hoadon';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function nhanVien(): BelongsTo
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien', 'Id');
    }

    public function benhNhan(): BelongsTo
    {
        return $this->belongsTo(BenhNhan::class, 'MaBenhNhan', 'Id');
    }

    public function tienTrinh(): BelongsTo
    {
        return $this->belongsTo(TienTrinhDieuTri::class, 'MaTienTrinh', 'Id');
    }
}
