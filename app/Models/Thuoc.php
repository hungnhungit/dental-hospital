<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thuoc extends Model
{
    use HasFactory;

    public $table = 'thuoc';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function loaiThuoc(): BelongsTo
    {
        return $this->belongsTo(LoaiThuoc::class, 'LoaiThuocID', 'Id');
    }

    public function donVi(): BelongsTo
    {
        return $this->belongsTo(DonViTinh::class, 'MaDonVi', 'Id');
    }
    public function nhapxuat(): HasMany
    {
        return $this->hasMany(NhapXuatThuoc::class, 'MaThuoc', 'Id');
    }
}
