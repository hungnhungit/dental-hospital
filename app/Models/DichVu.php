<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DichVu extends Model
{
    use HasFactory;

    public $table = 'dichvu';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $guarded = [];

    public function loaiDichVu(): BelongsTo
    {
        return $this->belongsTo(LoaiDichVu::class, 'LoaiDichVuID', 'Id');
    }
}
