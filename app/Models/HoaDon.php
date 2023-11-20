<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function dichvu(): BelongsToMany
    {
        return $this->belongsToMany(DichVu::class, 'chitiethoadon', 'HoaDonId', 'DichVuId')->as("payload")->withPivot('SoLuong');
    }

    public function getTextStatus(): string
    {

        $STATUS_MAP_TO_STATUS_TEXT = [
            'ChuaThanhToan' => "Chờ thanh toán",
            'DaThanhToan' => "Đã thanh toán",
            'Huy' => "Hủy thanh toán",
        ];

        return $STATUS_MAP_TO_STATUS_TEXT[$this['TrangThai']];
    }
}
