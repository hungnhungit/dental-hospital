<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiDichVu extends Model
{
    use HasFactory;

    protected $table = 'loaidichvu';

    protected $primaryKey = 'idLDV';

    public $timestamps = false;
}
