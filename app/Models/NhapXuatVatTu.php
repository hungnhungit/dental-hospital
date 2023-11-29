<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhapXuatVatTu extends Model
{
    use HasFactory;

    public $table = 'nhapxuatvattu';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function vattu(): BelongsTo
    {
        return $this->belongsTo(VatTu::class, 'MaVatTu', 'Id');
    }
}
