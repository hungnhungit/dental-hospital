<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
