<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thuoc extends Model
{
    use HasFactory;

    public $table = 'thuoc';

    public $timestamps = false;

    protected $primaryKey = 'idThuoc';

    protected $fillable = [];
}
