<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiTinTuc extends Model
{
    use HasFactory;

    protected $table = 'loaitintuc';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $guarded = [];
}
