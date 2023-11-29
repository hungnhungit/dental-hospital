<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhapXuatThuoc extends Model
{
    use HasFactory;

    public $table = 'nhapxuatthuoc';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function thuoc(): BelongsTo
    {
        return $this->belongsTo(Thuoc::class, 'MaThuoc', 'Id');
    }
}
