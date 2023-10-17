<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoaiThuoc extends Model
{
    use HasFactory;

    public $table = 'loaithuoc';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];
}
