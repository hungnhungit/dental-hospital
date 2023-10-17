<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TinTuc extends Model
{
    use HasFactory;

    public $table = 'tintuc';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'AdminId');
    }

    public function loaiTinTuc(): BelongsTo
    {
        return $this->belongsTo(LoaiTinTuc::class, 'LoaiTinTuc');
    }
}
