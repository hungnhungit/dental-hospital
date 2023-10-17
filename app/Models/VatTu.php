<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VatTu extends Model
{
    use HasFactory;

    public $table = 'vattu';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function loaiVatTu(): BelongsTo
    {
        return $this->belongsTo(LoaiVatTu::class, 'LoaiVatTuID', 'Id');
    }

    public function donVi(): BelongsTo
    {
        return $this->belongsTo(DonViTinh::class, 'MaDonVi', 'Id');
    }
}
