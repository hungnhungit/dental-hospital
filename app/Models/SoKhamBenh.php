<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoKhamBenh extends Model
{
    use HasFactory;

    public $table = 'sokhambenh';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function bacSi(): BelongsTo
    {
        return $this->belongsTo(NhanVien::class, 'MaBacSi');
    }

    public function benhNhan(): BelongsTo
    {
        return $this->belongsTo(BenhNhan::class, 'MaBenhNhan');
    }

    public function tienTrinhDieuTri(): HasMany
    {
        return $this->hasMany(TienTrinhDieuTri::class, 'MaSoKhamBenh');
    }

    public function getTextStatus(): string
    {
        $STATUS_RECORD_MAP_TO_STATUS_TEXT = [
            'ChoPheDuyet' => "Chờ phê duyệt",
            'DangDieutri' => "Đang điều trị",
            'Huy' => "Hủy bỏ",
            'ThanhCong' => "Thành công",
        ];
        return $STATUS_RECORD_MAP_TO_STATUS_TEXT[$this['TrangThai']];
    }
}
