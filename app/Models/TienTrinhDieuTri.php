<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TienTrinhDieuTri extends Model
{
    use HasFactory;

    public $table = 'tientrinhdieutri';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function thuoc(): BelongsTo
    {
        return $this->belongsTo(Thuoc::class, 'MaThuoc', 'Id');
    }

    public function vatTu(): BelongsTo
    {
        return $this->belongsTo(VatTu::class, 'MaVatTu', 'Id');
    }

    public function dichVu(): BelongsTo
    {
        return $this->belongsTo(DichVu::class, 'MaDichVu', 'Id');
    }

    public function hoadon(): HasOne
    {
        return $this->hasOne(HoaDon::class, 'MaTienTrinh', 'Id');
    }
}
