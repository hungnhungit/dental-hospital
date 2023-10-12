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

    protected $primaryKey = 'idHD';

    public function nhanVien(): BelongsTo
    {
        return $this->belongsTo(NhanVien::class, 'NguoiTao');
    }

    public function benhNhan(): BelongsTo
    {
        return $this->belongsTo(BenhNhan::class, 'BenhNhanId');
    }

    public function phuongThuc(): BelongsTo
    {
        return $this->belongsTo(ThanhToan::class, 'ThanhToanId');
    }
}
