<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DichVu extends Model
{
    use HasFactory;

    protected $fillable = [];

    public $table = 'dichvu';

    protected $primaryKey = 'idDV';

    public $timestamps = false;

    public function loaiDichVu(): BelongsTo
    {
        return $this->belongsTo(LoaiDichVu::class, 'LoaiDichVuId');
    }
}
