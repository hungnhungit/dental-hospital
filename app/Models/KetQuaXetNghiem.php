<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetQuaXetNghiem extends Model
{
    use HasFactory;

    public $table = 'ketquaxetnghiem';

    public $timestamps = false;

    protected $primaryKey = 'idKQXN';

    protected $fillable = [];
}
